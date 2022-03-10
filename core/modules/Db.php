<?php

class Db {
    private $dbh;
    private $test;
    private $app;

    function __construct (Object $db, App $app, Bool $test = false) {
        $this->app = $app;
        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->dbh = new PDO(
            $db->type . ':host=' . $db->host . ';dbname=' . $db->name,
            $db->user,
            $db->password,
            $options
        );
        $this->test = $test;
    }

    function updateAllDb ($api) {
        $this->reset();
        $championsList = [];
        $champions = $api->getChampions();
        $items = $api->getItems();
        foreach ($champions as $champion) {
            $this->insertChampion($champion);
            array_push($championsList, (object) ['name' => $champion->name, 'sprite' => $champion->image->sprite]);
            foreach ($champion->spells as $spell) {
                $this->insertSpell($spell, $champion->key);
            }
            $this->insertPassive($champion->passive, $champion->key, $champion->name . 'P');
            if ($this->test && $champion->key == 84) {
                break;
            }
        }
        foreach ($items as $id => $item) {
            $this->insertItem($item, $id);
            if ($this->test && $item->name == 'Ceinture du géant') {
                break;
            }
        }
    }

    function reset() {
        $sql = file_get_contents(__DIR__ . '/../../secure/scheme.sql');
        $this->dbh->exec($sql);
    }

    function insertChampion($champion) {
        $query = $this->dbh->prepare("INSERT INTO champions (
            name,
            `champion-key`,
            title,
            description,
            attack,
            defense,
            magic,
            difficulty,
            full,
            sprite,
            tags,
            energy,
            lore,
            allytips,
            enemytips,
            stats,
            skins
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $tags = json_encode($champion->tags);
        $stats = json_encode($champion->stats);
        $allytips = json_encode($champion->skins);
        $enemytips = json_encode($champion->enemytips);
        $skins = json_encode($champion->skins);
        $query->bindParam(1, $champion->name);
        $query->bindParam(2, $champion->key);
        $query->bindParam(3, $champion->title);
        $query->bindParam(4, $champion->blurb);
        $query->bindParam(5, $champion->info->attack);
        $query->bindParam(6, $champion->info->defense);
        $query->bindParam(7, $champion->info->magic);
        $query->bindParam(8, $champion->info->difficulty);
        $query->bindParam(9, $champion->image->full);
        $query->bindParam(10, $champion->image->sprite);
        $query->bindParam(11, $tags);
        $query->bindParam(12, $champion->partype);
        $query->bindParam(13, $champion->lore);
        $query->bindParam(14, $allytips);
        $query->bindParam(15, $enemytips);
        $query->bindParam(16, $stats);
        $query->bindParam(17, $skins);
        try {
            $query->execute();
        }
        catch (PDOException $Exception) {
            throw new Exception( $Exception->getMessage( ) , $Exception->getCode( ) );
        }
    }

    function insertSpell($spell, $key) {
        $query = $this->dbh->prepare("INSERT INTO spells (
            `champion-key`,
            name,
            `id-spell`,
            description,
            tooltip,
            leveltip,
            maxrank,
            cooldown,
            cooldownBurn,
            cost,
            costBurn,
            datavalues,
            effect,
            effectBurn,
            vars,
            costType,
            maxammo,
            spellrange,
            rangeBurn,
            full,
            sprite,
            ressource
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!empty($spell->leveltip)) {
            $leveltip = json_encode($spell->leveltip);
        }
        else {
            $leveltip = null;
        }
        $cooldown = json_encode($spell->cooldown);
        $cost = json_encode($spell->cost);
        $datavalues = json_encode($spell->datavalues);
        $effect = json_encode($spell->effect);
        $effectBurn = json_encode($spell->effectBurn);
        $vars = json_encode($spell->vars);
        $range = json_encode($spell->range);
        $effectBurn = json_encode($spell->effectBurn);
        $effectBurn = json_encode($spell->effectBurn);
        $effectBurn = json_encode($spell->effectBurn);
        $query->bindParam(1, $key);
        $query->bindParam(2, $spell->name);
        $query->bindParam(3, $spell->id);
        $query->bindParam(4, $spell->description);
        $query->bindParam(5, $spell->tooltip);
        $query->bindParam(6, $leveltip);
        $query->bindParam(7, $spell->maxrank);
        $query->bindParam(8, $cooldown);
        $query->bindParam(9, $spell->cooldownBurn);
        $query->bindParam(10, $cost);
        $query->bindParam(11, $spell->costBurn);
        $query->bindParam(12, $datavalues);
        $query->bindParam(13, $effect);
        $query->bindParam(14, $effectBurn);
        $query->bindParam(15, $vars);
        $query->bindParam(16, $spell->costType);
        $query->bindParam(17, $spell->maxammo);
        $query->bindParam(18, $range);
        $query->bindParam(19, $rangeBurn);
        $query->bindParam(20, $spell->image->full);
        $query->bindParam(21, $spell->image->sprite);
        $query->bindParam(22, $spell->resource);
        try {
            $query->execute();
        }
        catch (PDOException $Exception) {
            throw new Exception( $Exception->getMessage( ) , $Exception->getCode( ) );
        }
    }

    function insertPassive($spell, $key, $name) {
        $query = $this->dbh->prepare("INSERT INTO spells (
            `champion-key`,
            name,
            `id-spell`,
            description,
            full,
            sprite
        ) VALUES (?, ?, ?, ?, ?, ?)");
        $query->bindParam(1, $key);
        $query->bindParam(2, $spell->name);
        $query->bindParam(3, $name);
        $query->bindParam(4, $spell->description);
        $query->bindParam(5, $spell->image->full);
        $query->bindParam(6, $spell->image->sprite);
        try {
            $query->execute();
        }
        catch (PDOException $Exception) {
            throw new Exception( $Exception->getMessage( ) , $Exception->getCode( ) );
        }
    }

    function insertItem($item, $id) {
        $query = $this->dbh->prepare("INSERT INTO items (
            `item-id`,
            name,
            description,
            plaintext,
            `item-into`,
            full,
            sprite,
            gold,
            tags,
            stats,
            depth
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!empty($item->into)) {
            $into = json_encode($item->into);
        }
        else {
            $into = null;
        }
        $tags = json_encode($item->tags);
        $stats = json_encode($item->stats);
        if (empty($item->depth)) {
            $item->depth = 1;
        }
        $query->bindParam(1, $id);
        $query->bindParam(2, $item->name);
        $query->bindParam(3, $item->description);
        $query->bindParam(4, $item->plaintext);
        $query->bindParam(5, $into);
        $query->bindParam(6, $item->image->full);
        $query->bindParam(7, $item->image->sprite);
        $query->bindParam(8, $item->gold->base);
        $query->bindParam(9, $tags);
        $query->bindParam(10, $stats);
        $query->bindParam(11, $item->depth);
        try {
            $query->execute();
        }
        catch (PDOException $e) {
            dump($item->into);
            echo $e->getMessage();
            throw new PDOException($e->getMessage() , $e->getCode());
        }
    }

    function getChampionList () {
        $query = $this->dbh->prepare("SELECT name, full FROM champions");
        $query->execute();
        return $query->fetchAll();
    }

    function getChampion ($name) {
        $query = $this->dbh->prepare("SELECT * FROM champions WHERE LOWER(name) = ?");
        $query->bindParam(1, $name);
        $query->execute();
        return $query->fetch();
    }
}