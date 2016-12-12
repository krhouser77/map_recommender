<?php

namespace MapRec\MapRecBundle\Model\Map;

use MapRec\MapRecBundle\Model\Map;
use MapRec\MapRecBundle\Model\MapQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'map' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class MapTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'MapRec.MapRecBundle.Model.Map.MapTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'map';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\MapRec\\MapRecBundle\\Model\\Map';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'MapRec.MapRecBundle.Model.Map';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the map_id field
     */
    const COL_MAP_ID = 'map.map_id';

    /**
     * the column name for the map_name field
     */
    const COL_MAP_NAME = 'map.map_name';

    /**
     * the column name for the map_level field
     */
    const COL_MAP_LEVEL = 'map.map_level';

    /**
     * the column name for the map_tier field
     */
    const COL_MAP_TIER = 'map.map_tier';

    /**
     * the column name for the map_layout field
     */
    const COL_MAP_LAYOUT = 'map.map_layout';

    /**
     * the column name for the map_difficulty field
     */
    const COL_MAP_DIFFICULTY = 'map.map_difficulty';

    /**
     * the column name for the map_tileset field
     */
    const COL_MAP_TILESET = 'map.map_tileset';

    /**
     * the column name for the map_description field
     */
    const COL_MAP_DESCRIPTION = 'map.map_description';

    /**
     * the column name for the map_num_bosses field
     */
    const COL_MAP_NUM_BOSSES = 'map.map_num_bosses';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('MapId', 'MapName', 'MapLevel', 'MapTier', 'MapLayout', 'MapDifficulty', 'MapTileset', 'MapDescription', 'MapNumBosses', ),
        self::TYPE_CAMELNAME     => array('mapId', 'mapName', 'mapLevel', 'mapTier', 'mapLayout', 'mapDifficulty', 'mapTileset', 'mapDescription', 'mapNumBosses', ),
        self::TYPE_COLNAME       => array(MapTableMap::COL_MAP_ID, MapTableMap::COL_MAP_NAME, MapTableMap::COL_MAP_LEVEL, MapTableMap::COL_MAP_TIER, MapTableMap::COL_MAP_LAYOUT, MapTableMap::COL_MAP_DIFFICULTY, MapTableMap::COL_MAP_TILESET, MapTableMap::COL_MAP_DESCRIPTION, MapTableMap::COL_MAP_NUM_BOSSES, ),
        self::TYPE_FIELDNAME     => array('map_id', 'map_name', 'map_level', 'map_tier', 'map_layout', 'map_difficulty', 'map_tileset', 'map_description', 'map_num_bosses', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('MapId' => 0, 'MapName' => 1, 'MapLevel' => 2, 'MapTier' => 3, 'MapLayout' => 4, 'MapDifficulty' => 5, 'MapTileset' => 6, 'MapDescription' => 7, 'MapNumBosses' => 8, ),
        self::TYPE_CAMELNAME     => array('mapId' => 0, 'mapName' => 1, 'mapLevel' => 2, 'mapTier' => 3, 'mapLayout' => 4, 'mapDifficulty' => 5, 'mapTileset' => 6, 'mapDescription' => 7, 'mapNumBosses' => 8, ),
        self::TYPE_COLNAME       => array(MapTableMap::COL_MAP_ID => 0, MapTableMap::COL_MAP_NAME => 1, MapTableMap::COL_MAP_LEVEL => 2, MapTableMap::COL_MAP_TIER => 3, MapTableMap::COL_MAP_LAYOUT => 4, MapTableMap::COL_MAP_DIFFICULTY => 5, MapTableMap::COL_MAP_TILESET => 6, MapTableMap::COL_MAP_DESCRIPTION => 7, MapTableMap::COL_MAP_NUM_BOSSES => 8, ),
        self::TYPE_FIELDNAME     => array('map_id' => 0, 'map_name' => 1, 'map_level' => 2, 'map_tier' => 3, 'map_layout' => 4, 'map_difficulty' => 5, 'map_tileset' => 6, 'map_description' => 7, 'map_num_bosses' => 8, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('map');
        $this->setPhpName('Map');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\MapRec\\MapRecBundle\\Model\\Map');
        $this->setPackage('MapRec.MapRecBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('map_id', 'MapId', 'INTEGER', true, null, null);
        $this->addColumn('map_name', 'MapName', 'VARCHAR', true, 100, null);
        $this->addColumn('map_level', 'MapLevel', 'INTEGER', true, null, 0);
        $this->addColumn('map_tier', 'MapTier', 'INTEGER', true, null, 0);
        $this->addColumn('map_layout', 'MapLayout', 'VARCHAR', true, 5, 'X');
        $this->addColumn('map_difficulty', 'MapDifficulty', 'INTEGER', true, null, 0);
        $this->addColumn('map_tileset', 'MapTileset', 'VARCHAR', false, 100, null);
        $this->addColumn('map_description', 'MapDescription', 'VARCHAR', true, 500, 'No Description Available');
        $this->addColumn('map_num_bosses', 'MapNumBosses', 'INTEGER', false, null, 0);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('CardToMap', '\\MapRec\\MapRecBundle\\Model\\CardToMap', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':map_id',
    1 => ':map_id',
  ),
), null, null, 'CardToMaps', false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('MapId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('MapId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('MapId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('MapId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('MapId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('MapId', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('MapId', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? MapTableMap::CLASS_DEFAULT : MapTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Map object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = MapTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = MapTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + MapTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = MapTableMap::OM_CLASS;
            /** @var Map $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            MapTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = MapTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = MapTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Map $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                MapTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(MapTableMap::COL_MAP_ID);
            $criteria->addSelectColumn(MapTableMap::COL_MAP_NAME);
            $criteria->addSelectColumn(MapTableMap::COL_MAP_LEVEL);
            $criteria->addSelectColumn(MapTableMap::COL_MAP_TIER);
            $criteria->addSelectColumn(MapTableMap::COL_MAP_LAYOUT);
            $criteria->addSelectColumn(MapTableMap::COL_MAP_DIFFICULTY);
            $criteria->addSelectColumn(MapTableMap::COL_MAP_TILESET);
            $criteria->addSelectColumn(MapTableMap::COL_MAP_DESCRIPTION);
            $criteria->addSelectColumn(MapTableMap::COL_MAP_NUM_BOSSES);
        } else {
            $criteria->addSelectColumn($alias . '.map_id');
            $criteria->addSelectColumn($alias . '.map_name');
            $criteria->addSelectColumn($alias . '.map_level');
            $criteria->addSelectColumn($alias . '.map_tier');
            $criteria->addSelectColumn($alias . '.map_layout');
            $criteria->addSelectColumn($alias . '.map_difficulty');
            $criteria->addSelectColumn($alias . '.map_tileset');
            $criteria->addSelectColumn($alias . '.map_description');
            $criteria->addSelectColumn($alias . '.map_num_bosses');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(MapTableMap::DATABASE_NAME)->getTable(MapTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(MapTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(MapTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new MapTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Map or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Map object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MapTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \MapRec\MapRecBundle\Model\Map) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(MapTableMap::DATABASE_NAME);
            $criteria->add(MapTableMap::COL_MAP_ID, (array) $values, Criteria::IN);
        }

        $query = MapQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            MapTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                MapTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the map table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return MapQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Map or Criteria object.
     *
     * @param mixed               $criteria Criteria or Map object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MapTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Map object
        }

        if ($criteria->containsKey(MapTableMap::COL_MAP_ID) && $criteria->keyContainsValue(MapTableMap::COL_MAP_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.MapTableMap::COL_MAP_ID.')');
        }


        // Set the correct dbName
        $query = MapQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // MapTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
MapTableMap::buildTableMap();
