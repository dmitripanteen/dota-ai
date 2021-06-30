<?php

namespace DaMatch\Controller;

use DaHero\Repository\HeroRepository;
use DaItem\Repository\ItemRepository;
use DaItem\Repository\NeutralItemRepository;
use DaMatch\Entity\Match;
use DaMatch\Entity\MatchPlayer;
use DaMatch\Helper\MatchHelper;
use DaMatch\Repository\MatchPlayerRepository;
use DaMatch\Repository\MatchRepository;
use Doctrine\ORM\EntityManager;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Laminas\Paginator\Paginator;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class MatchController extends AbstractActionController
{

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var HeroRepository
     */
    private $heroRepository;

    /**
     * @var ItemRepository
     */
    private $itemRepository;

    /**
     * @var NeutralItemRepository
     */
    private $neutralItemRepository;

    /**
     * @var MatchRepository
     */
    private $matchRepository;

    /**
     * @var MatchPlayerRepository
     */
    private $matchPlayerRepository;

    /**
     * MatchController constructor.
     *
     * @param $entityManager
     * @param $heroRepository
     * @param $itemRepository
     * @param $neutralItemRepository
     * @param $matchRepository
     * @param $matchPlayerRepository
     */
    public function __construct(
        $entityManager,
        $heroRepository,
        $itemRepository,
        $neutralItemRepository,
        $matchRepository,
        $matchPlayerRepository
    ) {
        $this->entityManager = $entityManager;
        $this->heroRepository = $heroRepository;
        $this->itemRepository = $itemRepository;
        $this->neutralItemRepository = $neutralItemRepository;
        $this->matchRepository = $matchRepository;
        $this->matchPlayerRepository = $matchPlayerRepository;
    }

    public function listMatchesAction()
    {
        $page = $this->params()->fromQuery('page', 1);
        $query = $this->matchRepository->listAll();
        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(20);
        $paginator->setCurrentPageNumber($page);
        return new ViewModel(
            [
                'matches' => $paginator
            ]
        );
    }

    public function fetchMatchAction()
    {
        $queryParams = $this->params()->fromQuery(); //match GET-parameter
        if ($queryParams['match'] && is_numeric($queryParams['match'])) {
            $matchJSON = file_get_contents('https://api.opendota.com/api/matches/' . $queryParams['match']);
            $matchJSON = json_decode($matchJSON);
            $matchFromDb = $this->matchRepository->findOneBy(
                [
                    'openDotaMatchId' => $matchJSON->match_id,
                ]
            );
            if (!$matchFromDb) {
                $match = new Match();
                $match->setOpenDotaMatchId($matchJSON->match_id)
                    ->setDuration($matchJSON->duration)
                    ->setRadiantScore($matchJSON->radiant_score)
                    ->setDireScore($matchJSON->dire_score)
                    ->setLobbyType($matchJSON->lobby_type)
                    ->setGameMode($matchJSON->game_mode)
                    ->setRadiantWin((bool)$matchJSON->radiant_win)
                    ->setStartTime($matchJSON->start_time);
                $this->entityManager->persist($match);
                $this->entityManager->flush();

                /**
                 * @var Match
                 */
                $savedMatch = $this->matchRepository->findOneBy(
                    [
                        'openDotaMatchId' => $matchJSON->match_id,
                    ]
                );
                for ($i = 0; $i < 10; $i++) {
                    $matchPlayer = new MatchPlayer();
                    $matchPlayer->setMatch($savedMatch)
                        ->setBackpack0(
                            $this->itemRepository->findById(
                                MatchHelper::mapOpendotaItemsToLocal($matchJSON->players[$i]->backpack_0)
                            )
                            ?? null
                        )
                        ->setBackpack1(
                            $this->itemRepository->findById(
                                MatchHelper::mapOpendotaItemsToLocal($matchJSON->players[$i]->backpack_1)
                            )
                            ?? null
                        )
                        ->setBackpack2(
                            $this->itemRepository->findById(
                                MatchHelper::mapOpendotaItemsToLocal($matchJSON->players[$i]->backpack_2)
                            )
                            ?? null
                        )
                        ->setBackpack3(
                            $this->itemRepository->findById(
                                MatchHelper::mapOpendotaItemsToLocal($matchJSON->players[$i]->backpack_3)
                            )
                            ?? null
                        )
                        ->setHero(
                            $this->heroRepository->findById(
                                MatchHelper::mapOpendotaHeroesToLocal($matchJSON->players[$i]->hero_id)
                            )
                        )
                        ->setItem0(
                            $this->itemRepository->findById(
                                MatchHelper::mapOpendotaItemsToLocal($matchJSON->players[$i]->item_0)
                            ) ?? null
                        )
                        ->setItem1(
                            $this->itemRepository->findById(
                                MatchHelper::mapOpendotaItemsToLocal($matchJSON->players[$i]->item_1)
                            ) ?? null
                        )
                        ->setItem2(
                            $this->itemRepository->findById(
                                MatchHelper::mapOpendotaItemsToLocal($matchJSON->players[$i]->item_2)
                            ) ?? null
                        )
                        ->setItem3(
                            $this->itemRepository->findById(
                                MatchHelper::mapOpendotaItemsToLocal($matchJSON->players[$i]->item_3)
                            ) ?? null
                        )
                        ->setItem4(
                            $this->itemRepository->findById(
                                MatchHelper::mapOpendotaItemsToLocal($matchJSON->players[$i]->item_4)
                            ) ?? null
                        )
                        ->setItem5(
                            $this->itemRepository->findById(
                                MatchHelper::mapOpendotaItemsToLocal($matchJSON->players[$i]->item_5)
                            ) ?? null
                        )
                        ->setAccountId($matchJSON->players[$i]->account_id)
                        ->setKills($matchJSON->players[$i]->kills)
                        ->setDeaths($matchJSON->players[$i]->deaths)
                        ->setAssists($matchJSON->players[$i]->assists)
                        ->setDenies($matchJSON->players[$i]->denies)
                        ->setLastHits($matchJSON->players[$i]->last_hits)
                        ->setPersonaName($matchJSON->players[$i]->personaname)
                        ->setIsRadiant($matchJSON->players[$i]->isRadiant)
                        ->setWin($matchJSON->players[$i]->win)
                        ->setLose($matchJSON->players[$i]->lose)
                        ->setNeutralItem(
                            $this->neutralItemRepository->findById(
                                MatchHelper::mapOpendotaNeutralItemsToLocal($matchJSON->players[$i]->item_neutral)
                            ) ?? null
                        );
                    $this->entityManager->persist($matchPlayer);
                    $this->entityManager->flush();
                }

                $matchPlayers = $this->matchPlayerRepository->findBy(
                    [
                        'match' => $savedMatch->getId(),
                    ]
                );
                $savedMatch->setPlayer0($matchPlayers[0])
                    ->setPlayer1($matchPlayers[1])
                    ->setPlayer2($matchPlayers[2])
                    ->setPlayer3($matchPlayers[3])
                    ->setPlayer4($matchPlayers[4])
                    ->setPlayer5($matchPlayers[5])
                    ->setPlayer6($matchPlayers[6])
                    ->setPlayer7($matchPlayers[7])
                    ->setPlayer8($matchPlayers[8])
                    ->setPlayer9($matchPlayers[9]);
                $this->entityManager->flush();
            }

            return 'Match data is saved to DB';
        }

        return 'Invalid match ID provided';
    }

    public function showMatchAction()
    {
        $matchId = $this->params()->fromRoute('matchId', 0);
        /**
         * @var $match Match
         */
        $match = $this->matchRepository->findById($matchId);

        return new ViewModel(
            [
                'match' => $match,
            ]
        );
    }
}