<?php

namespace DaBase\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\QueryBuilder;
use Exception;
use InvalidArgumentException;
use Doctrine\ORM\Query\Expr\Orx;
use Doctrine\ORM\Query\Expr\Andx;
use Generator;

use function in_array;
use function is_array;
use function is_int;

/**
 * Class CustomRepository
 */
class CustomRepository extends EntityRepository
{
    /**
     * @param array $criteria
     *
     * @return mixed
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     * @throws QueryException
     */
    public function findFirstByCriteria(array $criteria)
    {
        $criteria['_page'] = 1;
        $criteria['_size'] = 1;
        return $this->findOneByCriteria($criteria);
    }

    /**
     * @param array $criteria
     *
     * @return mixed
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     * @throws QueryException
     */
    public function findOneByCriteria(array $criteria)
    {
        return $this->runFindByCriteria($criteria, true);
    }

    /**
     * @param array $criteria
     *
     * @return mixed
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     * @throws QueryException
     */
    public function findByCriteria(array $criteria)
    {
        return $this->runFindByCriteria($criteria);
    }

    /**
     * @param array $criteria
     *
     * @return int
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     * @throws QueryException
     */
    public function countByCriteria(array $criteria): int
    {
        return $this->runFindByCriteria($criteria, false, false, true);
    }

    /**
     * @param array $criteria
     *
     * @return mixed
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     * @throws QueryException
     */
    public function findArrayByCriteria(array $criteria)
    {
        return $this->runFindByCriteria($criteria, false, true);
    }

    /**
     * @param array $criteria
     * @param bool  $one
     * @param bool  $array
     * @param bool  $count
     *
     * @return mixed
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     * @throws QueryException
     */
    private function runFindByCriteria(
        array $criteria,
        $one = false,
        $array = false,
        $count = false
    ) {
        $indexBy = $criteria['_index_by'] ?? null;
        $orderBy = $criteria['_order_by'] ?? null;
        $page = $criteria['_page'] ?? null;
        $size = $criteria['_size'] ?? null;
        $fields = $criteria['_fields'] ?? [];
        $array = $criteria['_array'] ?? $array;
        if ($page && !$size) {
            $size = 100;
        }
        unset(
            $criteria['_index_by'],
            $criteria['_order_by'],
            $criteria['_page'],
            $criteria['_size'],
            $criteria['_fields'],
            $criteria['_array']
        );
        $qb = $this->createQueryBuilder('e');
        if ($fields) {
            $first = true;
            foreach ($fields as $field) {
                $method = $first ? 'select' : 'addSelect';
                $first = false;
                $qb->$method('e.' . $field);
            }
        }
        if ($count) {
            $qb->select($qb->expr()->count('e'));
        }
        if ($criteria) {
            $qb->where($this->buildCriteriaStart($qb, $criteria));
        }
        if (!$count && $orderBy) {
            foreach ($orderBy as $order) {
                $property = $order;
                $direction = 'ASC';
                if (is_array($order)) {
                    list($property, $direction) = $order;
                }
                $qb->addOrderBy('e.' . $property, $direction);
            }
        }
        if (!$count && $page && $size) {
            $qb->setFirstResult($size * ($page - 1));
            $qb->setMaxResults($size);
        }
        if (!$count && $indexBy) {
            $qb->indexBy('e', 'e.' . $indexBy);
        }
        $query = $qb->getQuery();
        if ($array && !$one) {
            return $query->getArrayResult();
        }
        if ($count) {
            return $query->getSingleScalarResult();
        }
        return $one
            ? $query->getOneOrNullResult(
                $array ? AbstractQuery::HYDRATE_ARRAY : null
            )
            : $query->getResult();
    }

    /**
     * @param QueryBuilder $qb
     * @param array        $criteria
     *
     * @return Andx|Orx
     */
    private function buildCriteriaStart(QueryBuilder $qb, array $criteria)
    {
        $vars = [];
        return $this->buildCriteria($qb, $criteria, $vars);
    }

    /**
     * @param QueryBuilder $qb
     * @param array        $criteria
     * @param array        $vars
     * @param bool         $or
     *
     * @return AndX|OrX
     */
    private function buildCriteria(
        QueryBuilder $qb,
        array $criteria,
        array &$vars,
        $or = false
    ) {
        $cond = $qb->expr()->andX();
        if ($or) {
            $cond = $qb->expr()->orX();
        }
        foreach ($criteria as $field => $value) {
            if (is_int($field) && is_array($value)) {
                $field = key($value);
                $value = reset($value);
            }
            if (in_array($field, ['$and', '$or'], true)) {
                $cond->add(
                    $this->buildCriteria($qb, $value, $vars, $field === '$or')
                );
                continue;
            }
            list($field, $condition) = $this->parseFieldCondition($field);
            if ($value === null) {
                $condition = $condition === 'eq' ? 'isNull' : 'isNotNull';
                $cond->add($qb->expr()->$condition('e.' . $field));
            } else {
                $var = $this->incrementVariable($field, $vars);
                if (strpos($field, '_') === 0) {
                    $field = substr($field, 1);
                }
                $cond->add(
                    $qb->expr()->$condition(
                        'e.' . $field,
                        ':' . $var
                    )
                );
                $value = $value->getId();
                $qb->setParameter($var, $value);
            }
        }
        return $cond;
    }

    /**
     * @param string $field
     *
     * @return array
     */
    private function parseFieldCondition($field)
    {
        $condition = 'eq';
        $fieldMod = $field;
        switch (substr($field, 0, 1)) {
            case '!':
                $condition = 'neq';
                $fieldMod = substr($field, 1);
                break;
            case '<':
                $condition = 'lt';
                $fieldMod = substr($field, 1);
                break;
            case '>':
                $condition = 'gt';
                $fieldMod = substr($field, 1);
                break;
            default:
                break;
        }
        switch (substr($field, 0, 2)) {
            case '<=':
                $condition = 'lte';
                $fieldMod = substr($field, 2);
                break;
            case '>=':
                $condition = 'gte';
                $fieldMod = substr($field, 2);
                break;
            default:
                break;
        }
        switch (substr($field, 0, 3)) {
            case 'in:':
                $condition = 'in';
                $fieldMod = substr($field, 3);
                break;
            case 'lk:':
                $condition = 'like';
                $fieldMod = substr($field, 3);
                break;
            default:
                break;
        }
        switch (substr($field, 0, 4)) {
            case '!in:':
                $condition = 'notIn';
                $fieldMod = substr($field, 4);
                break;
            case '!lk:':
                $condition = 'notLike';
                $fieldMod = substr($field, 4);
                break;
            default:
                break;
        }
        return [$fieldMod, $condition];
    }

    /**
     * @param       $field
     * @param array $vars
     *
     * @return string
     */
    private function incrementVariable($field, array &$vars)
    {
        // we cannot use dots in the variable names
        $field = str_replace('.', '', $field);
        if (isset($vars[$field])) {
            return $field . ++$vars[$field];
        }
        $vars[$field] = 0;
        return $field . 0;
    }

    /**
     * @param $id
     *
     * @return mixed
     *
     * @throws NonUniqueResultException
     */
    public function findById($id)
    {
        $qb = $this->createQueryBuilder('e');
        $qb->where($qb->expr()->eq('e.id', ':id'));
        $qb->setParameter('id', $id);
        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @throws OptimisticLockException
     */
    public function flush()
    {
        $this->getEntityManager()->flush();
    }

    /**
     * @param array ...$params
     *
     * @return mixed
     *
     * @throws OptimisticLockException
     */
    public function create(...$params)
    {
        $entity = $this->createPersisted(...$params);
        $this->flush();
        return $entity;
    }

    /**
     * @param array ...$params
     *
     * @return mixed
     */
    public function createPersisted(...$params)
    {
        $entity = $this->createEntity(...$params);
        $this->getEntityManager()->persist($entity);
        return $entity;
    }

    /**
     * @param array ...$params
     *
     * @return mixed
     */
    public function createEntity(...$params)
    {
        return new $this->_entityName(...$params);
    }

    /**
     * @param      $entity
     * @param bool $flush
     *
     * @return mixed
     *
     * @throws OptimisticLockException
     */
    public function createFromObject($entity, $flush = true)
    {
        if (!$this->checkEntity($entity)) {
            throw new InvalidArgumentException();
        }
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->flush();
        }
        return $entity;
    }

    /**
     * @param      $entity
     * @param bool $flush
     *
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function remove($entity, $flush = true)
    {
        $this->removeEntity($entity);
        if ($flush) {
            $this->flush();
        }
    }

    /**
     * @param $entity
     *
     * @throws Exception
     */
    public function removeEntity($entity)
    {
        if (is_a($entity, $this->getEntityName())) {
            $this->getEntityManager()->remove($entity);
        } else {
            throw new Exception('Invalid entity');
        }
    }

    /**
     * @param null $alias
     * @param null $indexBy
     *
     * @return QueryBuilder
     */
    public function createQueryBuilder($alias = null, $indexBy = null)
    {
        if ($alias === null) {
            return $this->getEntityManager()->createQueryBuilder();
        }
        return parent::createQueryBuilder(
            $alias,
            $indexBy
        );
    }

    /**
     * @param bool $detach
     *
     * @return Generator
     */
    public function getAll($detach = true)
    {
        $qb = $this->createQueryBuilder('e');
        $iterator = $qb->getQuery()->iterate();
        foreach ($iterator as $row) {
            yield $row[0];
            if ($detach) {
                $this->getEntityManager()->detach($row[0]);
            }
        }
    }

    /**
     * @param $entity
     *
     * @throws Exception
     */
    public function update($entity)
    {
        if ($this->checkEntity($entity)) {
            $this->flush();
        } else {
            throw new Exception('Invalid entity');
        }
    }

    /**
     * @param $entity
     *
     * @return bool
     */
    public function checkEntity($entity)
    {
        return is_a($entity, $this->getEntityName());
    }

    /**
     * @param mixed $entity
     */
    public function detach($entity)
    {
        if (!$this->checkEntity($entity)) {
            throw new InvalidArgumentException('Not the expected entity');
        }
        $this->getEntityManager()->detach($entity);
    }

    public function persist($entity)
    {
        if (!$this->checkEntity($entity)) {
            throw new InvalidArgumentException();
        }
        $this->getEntityManager()->persist($entity);
        return $entity;
    }

    /**
     * @return null|callable
     */
    public static function extractAdminData()
    {
        return null;
    }

    /**
     * @param mixed $entity
     */
    public function refresh($entity)
    {
        if (!$this->checkEntity($entity)) {
            throw new InvalidArgumentException();
        }
        $this->getEntityManager()->refresh($entity);
    }

    /**
     * @param array $criteria
     */
    public function deleteByCriteria(array $criteria)
    {
        unset(
            $criteria['_index_by'],
            $criteria['_order_by'],
            $criteria['_page'],
            $criteria['_size']
        );
        $qb = $this->createQueryBuilder();
        $qb->delete($this->getEntityName(), 'e');
        if ($criteria) {
            $qb->where($this->buildCriteriaStart($qb, $criteria));
        }
        $qb->getQuery()->execute();
    }

}