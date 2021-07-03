# DotaAI app based on zf3

To run the app run
```bash
composer install
```
Import DB dump file from `/data/sql/dota-ai-init-data.sql`

###WARNING! Fixes:
- `Laminas\Form\View\Helper\AbstractHelper` line 14: replace `Laminas` namespace to `Zend`
- `Zend\I18n\View\Helper\AbstractTranslatorHelper` line 12: replace `Zend` namespace to `Laminas`

###List of routes:
- `/` and `/hero` - list of heroes
- `/hero/:hero` - hero page
- `/hero/:hero/edit` - edit hero
- `/hero/add` - add new hero
- `/heroes/hero-builder` - hero builder page
- `/talents` - list of all talents
- `/talents/:hero/add` - add talents for hero
- `/talents/:hero/edit` - edit hero talents
- `/abilities/:hero/add` - add hero skills
- `/abilities/:hero/edit/:abilityId` - edit ability
- `/items` - list of items
- `/items/add` - add new item
- `/items/:item` - item page
- `/items/:item/edit` - edit item
- `/neutral-items` - list of neutral items
- `/neutral-items/add` - add new neutral item
- `/neutral-items/:neutralItem` - neutral item page
- `/neutral-items/:neutralItem/edit` - edit neutral item
- `/matches` - list matches
- `/matches/:matchId` - match page
- `/matches/fetch?match=:matchId` - fetch match data from OpenDota API
- `/stats/heroes?sort=:sortBy` - heroes statistics
- `/stats/neutral-items?sort=:sortBy` - items statistics
- `/stats/items?sort=:sortBy` - neutral items statistics
###data-endpoints:
- `/hero/:heroId/data?level=:level&talents=:talentsIds&items=:itemsIds&neutral-item=:neutralItemId`
- `/items/data?items=:itemsIds`
- `/neutral-items/data?neutral-item=:neutralItemId`