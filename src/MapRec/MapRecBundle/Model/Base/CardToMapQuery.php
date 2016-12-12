<?php

namespace MapRec\MapRecBundle\Model\Base;

use \Exception;
use \PDO;
use MapRec\MapRecBundle\Model\CardToMap as ChildCardToMap;
use MapRec\MapRecBundle\Model\CardToMapQuery as ChildCardToMapQuery;
use MapRec\MapRecBundle\Model\Map\CardToMapTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'card_to_map' table.
 *
 *
 *
 * @method     ChildCardToMapQuery orderByCardToMapsId($order = Criteria::ASC) Order by the card_to_maps_id column
 * @method     ChildCardToMapQuery orderByCardId($order = Criteria::ASC) Order by the card_id column
 * @method     ChildCardToMapQuery orderByMapId($order = Criteria::ASC) Order by the map_id column
 *
 * @method     ChildCardToMapQuery groupByCardToMapsId() Group by the card_to_maps_id column
 * @method     ChildCardToMapQuery groupByCardId() Group by the card_id column
 * @method     ChildCardToMapQuery groupByMapId() Group by the map_id column
 *
 * @method     ChildCardToMapQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCardToMapQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCardToMapQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCardToMapQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCardToMapQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCardToMapQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCardToMapQuery leftJoinCard($relationAlias = null) Adds a LEFT JOIN clause to the query using the Card relation
 * @method     ChildCardToMapQuery rightJoinCard($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Card relation
 * @method     ChildCardToMapQuery innerJoinCard($relationAlias = null) Adds a INNER JOIN clause to the query using the Card relation
 *
 * @method     ChildCardToMapQuery joinWithCard($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Card relation
 *
 * @method     ChildCardToMapQuery leftJoinWithCard() Adds a LEFT JOIN clause and with to the query using the Card relation
 * @method     ChildCardToMapQuery rightJoinWithCard() Adds a RIGHT JOIN clause and with to the query using the Card relation
 * @method     ChildCardToMapQuery innerJoinWithCard() Adds a INNER JOIN clause and with to the query using the Card relation
 *
 * @method     ChildCardToMapQuery leftJoinMap($relationAlias = null) Adds a LEFT JOIN clause to the query using the Map relation
 * @method     ChildCardToMapQuery rightJoinMap($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Map relation
 * @method     ChildCardToMapQuery innerJoinMap($relationAlias = null) Adds a INNER JOIN clause to the query using the Map relation
 *
 * @method     ChildCardToMapQuery joinWithMap($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Map relation
 *
 * @method     ChildCardToMapQuery leftJoinWithMap() Adds a LEFT JOIN clause and with to the query using the Map relation
 * @method     ChildCardToMapQuery rightJoinWithMap() Adds a RIGHT JOIN clause and with to the query using the Map relation
 * @method     ChildCardToMapQuery innerJoinWithMap() Adds a INNER JOIN clause and with to the query using the Map relation
 *
 * @method     \MapRec\MapRecBundle\Model\CardQuery|\MapRec\MapRecBundle\Model\MapQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCardToMap findOne(ConnectionInterface $con = null) Return the first ChildCardToMap matching the query
 * @method     ChildCardToMap findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCardToMap matching the query, or a new ChildCardToMap object populated from the query conditions when no match is found
 *
 * @method     ChildCardToMap findOneByCardToMapsId(int $card_to_maps_id) Return the first ChildCardToMap filtered by the card_to_maps_id column
 * @method     ChildCardToMap findOneByCardId(int $card_id) Return the first ChildCardToMap filtered by the card_id column
 * @method     ChildCardToMap findOneByMapId(int $map_id) Return the first ChildCardToMap filtered by the map_id column *

 * @method     ChildCardToMap requirePk($key, ConnectionInterface $con = null) Return the ChildCardToMap by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCardToMap requireOne(ConnectionInterface $con = null) Return the first ChildCardToMap matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCardToMap requireOneByCardToMapsId(int $card_to_maps_id) Return the first ChildCardToMap filtered by the card_to_maps_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCardToMap requireOneByCardId(int $card_id) Return the first ChildCardToMap filtered by the card_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCardToMap requireOneByMapId(int $map_id) Return the first ChildCardToMap filtered by the map_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCardToMap[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCardToMap objects based on current ModelCriteria
 * @method     ChildCardToMap[]|ObjectCollection findByCardToMapsId(int $card_to_maps_id) Return ChildCardToMap objects filtered by the card_to_maps_id column
 * @method     ChildCardToMap[]|ObjectCollection findByCardId(int $card_id) Return ChildCardToMap objects filtered by the card_id column
 * @method     ChildCardToMap[]|ObjectCollection findByMapId(int $map_id) Return ChildCardToMap objects filtered by the map_id column
 * @method     ChildCardToMap[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CardToMapQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MapRec\MapRecBundle\Model\Base\CardToMapQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\MapRec\\MapRecBundle\\Model\\CardToMap', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCardToMapQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCardToMapQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCardToMapQuery) {
            return $criteria;
        }
        $query = new ChildCardToMapQuery();
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
     * @return ChildCardToMap|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CardToMapTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CardToMapTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildCardToMap A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT card_to_maps_id, card_id, map_id FROM card_to_map WHERE card_to_maps_id = :p0';
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
            /** @var ChildCardToMap $obj */
            $obj = new ChildCardToMap();
            $obj->hydrate($row);
            CardToMapTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildCardToMap|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCardToMapQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CardToMapTableMap::COL_CARD_TO_MAPS_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCardToMapQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CardToMapTableMap::COL_CARD_TO_MAPS_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the card_to_maps_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCardToMapsId(1234); // WHERE card_to_maps_id = 1234
     * $query->filterByCardToMapsId(array(12, 34)); // WHERE card_to_maps_id IN (12, 34)
     * $query->filterByCardToMapsId(array('min' => 12)); // WHERE card_to_maps_id > 12
     * </code>
     *
     * @param     mixed $cardToMapsId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCardToMapQuery The current query, for fluid interface
     */
    public function filterByCardToMapsId($cardToMapsId = null, $comparison = null)
    {
        if (is_array($cardToMapsId)) {
            $useMinMax = false;
            if (isset($cardToMapsId['min'])) {
                $this->addUsingAlias(CardToMapTableMap::COL_CARD_TO_MAPS_ID, $cardToMapsId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cardToMapsId['max'])) {
                $this->addUsingAlias(CardToMapTableMap::COL_CARD_TO_MAPS_ID, $cardToMapsId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CardToMapTableMap::COL_CARD_TO_MAPS_ID, $cardToMapsId, $comparison);
    }

    /**
     * Filter the query on the card_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCardId(1234); // WHERE card_id = 1234
     * $query->filterByCardId(array(12, 34)); // WHERE card_id IN (12, 34)
     * $query->filterByCardId(array('min' => 12)); // WHERE card_id > 12
     * </code>
     *
     * @see       filterByCard()
     *
     * @param     mixed $cardId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCardToMapQuery The current query, for fluid interface
     */
    public function filterByCardId($cardId = null, $comparison = null)
    {
        if (is_array($cardId)) {
            $useMinMax = false;
            if (isset($cardId['min'])) {
                $this->addUsingAlias(CardToMapTableMap::COL_CARD_ID, $cardId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cardId['max'])) {
                $this->addUsingAlias(CardToMapTableMap::COL_CARD_ID, $cardId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CardToMapTableMap::COL_CARD_ID, $cardId, $comparison);
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
     * @see       filterByMap()
     *
     * @param     mixed $mapId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCardToMapQuery The current query, for fluid interface
     */
    public function filterByMapId($mapId = null, $comparison = null)
    {
        if (is_array($mapId)) {
            $useMinMax = false;
            if (isset($mapId['min'])) {
                $this->addUsingAlias(CardToMapTableMap::COL_MAP_ID, $mapId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($mapId['max'])) {
                $this->addUsingAlias(CardToMapTableMap::COL_MAP_ID, $mapId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CardToMapTableMap::COL_MAP_ID, $mapId, $comparison);
    }

    /**
     * Filter the query by a related \MapRec\MapRecBundle\Model\Card object
     *
     * @param \MapRec\MapRecBundle\Model\Card|ObjectCollection $card The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCardToMapQuery The current query, for fluid interface
     */
    public function filterByCard($card, $comparison = null)
    {
        if ($card instanceof \MapRec\MapRecBundle\Model\Card) {
            return $this
                ->addUsingAlias(CardToMapTableMap::COL_CARD_ID, $card->getCardId(), $comparison);
        } elseif ($card instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CardToMapTableMap::COL_CARD_ID, $card->toKeyValue('PrimaryKey', 'CardId'), $comparison);
        } else {
            throw new PropelException('filterByCard() only accepts arguments of type \MapRec\MapRecBundle\Model\Card or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Card relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCardToMapQuery The current query, for fluid interface
     */
    public function joinCard($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Card');

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
            $this->addJoinObject($join, 'Card');
        }

        return $this;
    }

    /**
     * Use the Card relation Card object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MapRec\MapRecBundle\Model\CardQuery A secondary query class using the current class as primary query
     */
    public function useCardQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCard($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Card', '\MapRec\MapRecBundle\Model\CardQuery');
    }

    /**
     * Filter the query by a related \MapRec\MapRecBundle\Model\Map object
     *
     * @param \MapRec\MapRecBundle\Model\Map|ObjectCollection $map The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCardToMapQuery The current query, for fluid interface
     */
    public function filterByMap($map, $comparison = null)
    {
        if ($map instanceof \MapRec\MapRecBundle\Model\Map) {
            return $this
                ->addUsingAlias(CardToMapTableMap::COL_MAP_ID, $map->getMapId(), $comparison);
        } elseif ($map instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CardToMapTableMap::COL_MAP_ID, $map->toKeyValue('PrimaryKey', 'MapId'), $comparison);
        } else {
            throw new PropelException('filterByMap() only accepts arguments of type \MapRec\MapRecBundle\Model\Map or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Map relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCardToMapQuery The current query, for fluid interface
     */
    public function joinMap($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Map');

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
            $this->addJoinObject($join, 'Map');
        }

        return $this;
    }

    /**
     * Use the Map relation Map object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MapRec\MapRecBundle\Model\MapQuery A secondary query class using the current class as primary query
     */
    public function useMapQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMap($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Map', '\MapRec\MapRecBundle\Model\MapQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCardToMap $cardToMap Object to remove from the list of results
     *
     * @return $this|ChildCardToMapQuery The current query, for fluid interface
     */
    public function prune($cardToMap = null)
    {
        if ($cardToMap) {
            $this->addUsingAlias(CardToMapTableMap::COL_CARD_TO_MAPS_ID, $cardToMap->getCardToMapsId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the card_to_map table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CardToMapTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CardToMapTableMap::clearInstancePool();
            CardToMapTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CardToMapTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CardToMapTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CardToMapTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CardToMapTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CardToMapQuery
