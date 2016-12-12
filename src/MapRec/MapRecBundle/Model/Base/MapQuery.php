<?php

namespace MapRec\MapRecBundle\Model\Base;

use \Exception;
use \PDO;
use MapRec\MapRecBundle\Model\Map as ChildMap;
use MapRec\MapRecBundle\Model\MapQuery as ChildMapQuery;
use MapRec\MapRecBundle\Model\Map\MapTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'map' table.
 *
 *
 *
 * @method     ChildMapQuery orderByMapId($order = Criteria::ASC) Order by the map_id column
 * @method     ChildMapQuery orderByMapName($order = Criteria::ASC) Order by the map_name column
 * @method     ChildMapQuery orderByMapLevel($order = Criteria::ASC) Order by the map_level column
 * @method     ChildMapQuery orderByMapTier($order = Criteria::ASC) Order by the map_tier column
 * @method     ChildMapQuery orderByMapLayout($order = Criteria::ASC) Order by the map_layout column
 * @method     ChildMapQuery orderByMapDifficulty($order = Criteria::ASC) Order by the map_difficulty column
 * @method     ChildMapQuery orderByMapTileset($order = Criteria::ASC) Order by the map_tileset column
 * @method     ChildMapQuery orderByMapDescription($order = Criteria::ASC) Order by the map_description column
 * @method     ChildMapQuery orderByMapNumBosses($order = Criteria::ASC) Order by the map_num_bosses column
 *
 * @method     ChildMapQuery groupByMapId() Group by the map_id column
 * @method     ChildMapQuery groupByMapName() Group by the map_name column
 * @method     ChildMapQuery groupByMapLevel() Group by the map_level column
 * @method     ChildMapQuery groupByMapTier() Group by the map_tier column
 * @method     ChildMapQuery groupByMapLayout() Group by the map_layout column
 * @method     ChildMapQuery groupByMapDifficulty() Group by the map_difficulty column
 * @method     ChildMapQuery groupByMapTileset() Group by the map_tileset column
 * @method     ChildMapQuery groupByMapDescription() Group by the map_description column
 * @method     ChildMapQuery groupByMapNumBosses() Group by the map_num_bosses column
 *
 * @method     ChildMapQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMapQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMapQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMapQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildMapQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildMapQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildMapQuery leftJoinCardToMap($relationAlias = null) Adds a LEFT JOIN clause to the query using the CardToMap relation
 * @method     ChildMapQuery rightJoinCardToMap($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CardToMap relation
 * @method     ChildMapQuery innerJoinCardToMap($relationAlias = null) Adds a INNER JOIN clause to the query using the CardToMap relation
 *
 * @method     ChildMapQuery joinWithCardToMap($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CardToMap relation
 *
 * @method     ChildMapQuery leftJoinWithCardToMap() Adds a LEFT JOIN clause and with to the query using the CardToMap relation
 * @method     ChildMapQuery rightJoinWithCardToMap() Adds a RIGHT JOIN clause and with to the query using the CardToMap relation
 * @method     ChildMapQuery innerJoinWithCardToMap() Adds a INNER JOIN clause and with to the query using the CardToMap relation
 *
 * @method     \MapRec\MapRecBundle\Model\CardToMapQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMap findOne(ConnectionInterface $con = null) Return the first ChildMap matching the query
 * @method     ChildMap findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMap matching the query, or a new ChildMap object populated from the query conditions when no match is found
 *
 * @method     ChildMap findOneByMapId(int $map_id) Return the first ChildMap filtered by the map_id column
 * @method     ChildMap findOneByMapName(string $map_name) Return the first ChildMap filtered by the map_name column
 * @method     ChildMap findOneByMapLevel(int $map_level) Return the first ChildMap filtered by the map_level column
 * @method     ChildMap findOneByMapTier(int $map_tier) Return the first ChildMap filtered by the map_tier column
 * @method     ChildMap findOneByMapLayout(string $map_layout) Return the first ChildMap filtered by the map_layout column
 * @method     ChildMap findOneByMapDifficulty(int $map_difficulty) Return the first ChildMap filtered by the map_difficulty column
 * @method     ChildMap findOneByMapTileset(string $map_tileset) Return the first ChildMap filtered by the map_tileset column
 * @method     ChildMap findOneByMapDescription(string $map_description) Return the first ChildMap filtered by the map_description column
 * @method     ChildMap findOneByMapNumBosses(int $map_num_bosses) Return the first ChildMap filtered by the map_num_bosses column *

 * @method     ChildMap requirePk($key, ConnectionInterface $con = null) Return the ChildMap by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMap requireOne(ConnectionInterface $con = null) Return the first ChildMap matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMap requireOneByMapId(int $map_id) Return the first ChildMap filtered by the map_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMap requireOneByMapName(string $map_name) Return the first ChildMap filtered by the map_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMap requireOneByMapLevel(int $map_level) Return the first ChildMap filtered by the map_level column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMap requireOneByMapTier(int $map_tier) Return the first ChildMap filtered by the map_tier column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMap requireOneByMapLayout(string $map_layout) Return the first ChildMap filtered by the map_layout column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMap requireOneByMapDifficulty(int $map_difficulty) Return the first ChildMap filtered by the map_difficulty column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMap requireOneByMapTileset(string $map_tileset) Return the first ChildMap filtered by the map_tileset column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMap requireOneByMapDescription(string $map_description) Return the first ChildMap filtered by the map_description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMap requireOneByMapNumBosses(int $map_num_bosses) Return the first ChildMap filtered by the map_num_bosses column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMap[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMap objects based on current ModelCriteria
 * @method     ChildMap[]|ObjectCollection findByMapId(int $map_id) Return ChildMap objects filtered by the map_id column
 * @method     ChildMap[]|ObjectCollection findByMapName(string $map_name) Return ChildMap objects filtered by the map_name column
 * @method     ChildMap[]|ObjectCollection findByMapLevel(int $map_level) Return ChildMap objects filtered by the map_level column
 * @method     ChildMap[]|ObjectCollection findByMapTier(int $map_tier) Return ChildMap objects filtered by the map_tier column
 * @method     ChildMap[]|ObjectCollection findByMapLayout(string $map_layout) Return ChildMap objects filtered by the map_layout column
 * @method     ChildMap[]|ObjectCollection findByMapDifficulty(int $map_difficulty) Return ChildMap objects filtered by the map_difficulty column
 * @method     ChildMap[]|ObjectCollection findByMapTileset(string $map_tileset) Return ChildMap objects filtered by the map_tileset column
 * @method     ChildMap[]|ObjectCollection findByMapDescription(string $map_description) Return ChildMap objects filtered by the map_description column
 * @method     ChildMap[]|ObjectCollection findByMapNumBosses(int $map_num_bosses) Return ChildMap objects filtered by the map_num_bosses column
 * @method     ChildMap[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MapQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MapRec\MapRecBundle\Model\Base\MapQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\MapRec\\MapRecBundle\\Model\\Map', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMapQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMapQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMapQuery) {
            return $criteria;
        }
        $query = new ChildMapQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildMap|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MapTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = MapTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMap A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT map_id, map_name, map_level, map_tier, map_layout, map_difficulty, map_tileset, map_description, map_num_bosses FROM map WHERE map_id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildMap $obj */
            $obj = new ChildMap();
            $obj->hydrate($row);
            MapTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildMap|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildMapQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MapTableMap::COL_MAP_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMapQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MapTableMap::COL_MAP_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the map_id column
     *
     * Example usage:
     * <code>
     * $query->filterByMapId(1234); // WHERE map_id = 1234
     * $query->filterByMapId(array(12, 34)); // WHERE map_id IN (12, 34)
     * $query->filterByMapId(array('min' => 12)); // WHERE map_id > 12
     * </code>
     *
     * @param     mixed $mapId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMapQuery The current query, for fluid interface
     */
    public function filterByMapId($mapId = null, $comparison = null)
    {
        if (is_array($mapId)) {
            $useMinMax = false;
            if (isset($mapId['min'])) {
                $this->addUsingAlias(MapTableMap::COL_MAP_ID, $mapId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($mapId['max'])) {
                $this->addUsingAlias(MapTableMap::COL_MAP_ID, $mapId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MapTableMap::COL_MAP_ID, $mapId, $comparison);
    }

    /**
     * Filter the query on the map_name column
     *
     * Example usage:
     * <code>
     * $query->filterByMapName('fooValue');   // WHERE map_name = 'fooValue'
     * $query->filterByMapName('%fooValue%', Criteria::LIKE); // WHERE map_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mapName The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMapQuery The current query, for fluid interface
     */
    public function filterByMapName($mapName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mapName)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MapTableMap::COL_MAP_NAME, $mapName, $comparison);
    }

    /**
     * Filter the query on the map_level column
     *
     * Example usage:
     * <code>
     * $query->filterByMapLevel(1234); // WHERE map_level = 1234
     * $query->filterByMapLevel(array(12, 34)); // WHERE map_level IN (12, 34)
     * $query->filterByMapLevel(array('min' => 12)); // WHERE map_level > 12
     * </code>
     *
     * @param     mixed $mapLevel The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMapQuery The current query, for fluid interface
     */
    public function filterByMapLevel($mapLevel = null, $comparison = null)
    {
        if (is_array($mapLevel)) {
            $useMinMax = false;
            if (isset($mapLevel['min'])) {
                $this->addUsingAlias(MapTableMap::COL_MAP_LEVEL, $mapLevel['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($mapLevel['max'])) {
                $this->addUsingAlias(MapTableMap::COL_MAP_LEVEL, $mapLevel['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MapTableMap::COL_MAP_LEVEL, $mapLevel, $comparison);
    }

    /**
     * Filter the query on the map_tier column
     *
     * Example usage:
     * <code>
     * $query->filterByMapTier(1234); // WHERE map_tier = 1234
     * $query->filterByMapTier(array(12, 34)); // WHERE map_tier IN (12, 34)
     * $query->filterByMapTier(array('min' => 12)); // WHERE map_tier > 12
     * </code>
     *
     * @param     mixed $mapTier The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMapQuery The current query, for fluid interface
     */
    public function filterByMapTier($mapTier = null, $comparison = null)
    {
        if (is_array($mapTier)) {
            $useMinMax = false;
            if (isset($mapTier['min'])) {
                $this->addUsingAlias(MapTableMap::COL_MAP_TIER, $mapTier['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($mapTier['max'])) {
                $this->addUsingAlias(MapTableMap::COL_MAP_TIER, $mapTier['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MapTableMap::COL_MAP_TIER, $mapTier, $comparison);
    }

    /**
     * Filter the query on the map_layout column
     *
     * Example usage:
     * <code>
     * $query->filterByMapLayout('fooValue');   // WHERE map_layout = 'fooValue'
     * $query->filterByMapLayout('%fooValue%', Criteria::LIKE); // WHERE map_layout LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mapLayout The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMapQuery The current query, for fluid interface
     */
    public function filterByMapLayout($mapLayout = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mapLayout)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MapTableMap::COL_MAP_LAYOUT, $mapLayout, $comparison);
    }

    /**
     * Filter the query on the map_difficulty column
     *
     * Example usage:
     * <code>
     * $query->filterByMapDifficulty(1234); // WHERE map_difficulty = 1234
     * $query->filterByMapDifficulty(array(12, 34)); // WHERE map_difficulty IN (12, 34)
     * $query->filterByMapDifficulty(array('min' => 12)); // WHERE map_difficulty > 12
     * </code>
     *
     * @param     mixed $mapDifficulty The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMapQuery The current query, for fluid interface
     */
    public function filterByMapDifficulty($mapDifficulty = null, $comparison = null)
    {
        if (is_array($mapDifficulty)) {
            $useMinMax = false;
            if (isset($mapDifficulty['min'])) {
                $this->addUsingAlias(MapTableMap::COL_MAP_DIFFICULTY, $mapDifficulty['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($mapDifficulty['max'])) {
                $this->addUsingAlias(MapTableMap::COL_MAP_DIFFICULTY, $mapDifficulty['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MapTableMap::COL_MAP_DIFFICULTY, $mapDifficulty, $comparison);
    }

    /**
     * Filter the query on the map_tileset column
     *
     * Example usage:
     * <code>
     * $query->filterByMapTileset('fooValue');   // WHERE map_tileset = 'fooValue'
     * $query->filterByMapTileset('%fooValue%', Criteria::LIKE); // WHERE map_tileset LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mapTileset The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMapQuery The current query, for fluid interface
     */
    public function filterByMapTileset($mapTileset = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mapTileset)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MapTableMap::COL_MAP_TILESET, $mapTileset, $comparison);
    }

    /**
     * Filter the query on the map_description column
     *
     * Example usage:
     * <code>
     * $query->filterByMapDescription('fooValue');   // WHERE map_description = 'fooValue'
     * $query->filterByMapDescription('%fooValue%', Criteria::LIKE); // WHERE map_description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mapDescription The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMapQuery The current query, for fluid interface
     */
    public function filterByMapDescription($mapDescription = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mapDescription)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MapTableMap::COL_MAP_DESCRIPTION, $mapDescription, $comparison);
    }

    /**
     * Filter the query on the map_num_bosses column
     *
     * Example usage:
     * <code>
     * $query->filterByMapNumBosses(1234); // WHERE map_num_bosses = 1234
     * $query->filterByMapNumBosses(array(12, 34)); // WHERE map_num_bosses IN (12, 34)
     * $query->filterByMapNumBosses(array('min' => 12)); // WHERE map_num_bosses > 12
     * </code>
     *
     * @param     mixed $mapNumBosses The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMapQuery The current query, for fluid interface
     */
    public function filterByMapNumBosses($mapNumBosses = null, $comparison = null)
    {
        if (is_array($mapNumBosses)) {
            $useMinMax = false;
            if (isset($mapNumBosses['min'])) {
                $this->addUsingAlias(MapTableMap::COL_MAP_NUM_BOSSES, $mapNumBosses['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($mapNumBosses['max'])) {
                $this->addUsingAlias(MapTableMap::COL_MAP_NUM_BOSSES, $mapNumBosses['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MapTableMap::COL_MAP_NUM_BOSSES, $mapNumBosses, $comparison);
    }

    /**
     * Filter the query by a related \MapRec\MapRecBundle\Model\CardToMap object
     *
     * @param \MapRec\MapRecBundle\Model\CardToMap|ObjectCollection $cardToMap the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMapQuery The current query, for fluid interface
     */
    public function filterByCardToMap($cardToMap, $comparison = null)
    {
        if ($cardToMap instanceof \MapRec\MapRecBundle\Model\CardToMap) {
            return $this
                ->addUsingAlias(MapTableMap::COL_MAP_ID, $cardToMap->getMapId(), $comparison);
        } elseif ($cardToMap instanceof ObjectCollection) {
            return $this
                ->useCardToMapQuery()
                ->filterByPrimaryKeys($cardToMap->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCardToMap() only accepts arguments of type \MapRec\MapRecBundle\Model\CardToMap or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CardToMap relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMapQuery The current query, for fluid interface
     */
    public function joinCardToMap($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CardToMap');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CardToMap');
        }

        return $this;
    }

    /**
     * Use the CardToMap relation CardToMap object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MapRec\MapRecBundle\Model\CardToMapQuery A secondary query class using the current class as primary query
     */
    public function useCardToMapQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCardToMap($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CardToMap', '\MapRec\MapRecBundle\Model\CardToMapQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMap $map Object to remove from the list of results
     *
     * @return $this|ChildMapQuery The current query, for fluid interface
     */
    public function prune($map = null)
    {
        if ($map) {
            $this->addUsingAlias(MapTableMap::COL_MAP_ID, $map->getMapId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the map table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MapTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MapTableMap::clearInstancePool();
            MapTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MapTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MapTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            MapTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MapTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // MapQuery
