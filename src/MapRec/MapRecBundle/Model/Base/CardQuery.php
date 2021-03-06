<?php

namespace MapRec\MapRecBundle\Model\Base;

use \Exception;
use \PDO;
use MapRec\MapRecBundle\Model\Card as ChildCard;
use MapRec\MapRecBundle\Model\CardQuery as ChildCardQuery;
use MapRec\MapRecBundle\Model\Map\CardTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'card' table.
 *
 *
 *
 * @method     ChildCardQuery orderByCardId($order = Criteria::ASC) Order by the card_id column
 * @method     ChildCardQuery orderByCardName($order = Criteria::ASC) Order by the card_name column
 * @method     ChildCardQuery orderByRequiredCount($order = Criteria::ASC) Order by the required_count column
 *
 * @method     ChildCardQuery groupByCardId() Group by the card_id column
 * @method     ChildCardQuery groupByCardName() Group by the card_name column
 * @method     ChildCardQuery groupByRequiredCount() Group by the required_count column
 *
 * @method     ChildCardQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCardQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCardQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCardQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCardQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCardQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCardQuery leftJoinCardToMap($relationAlias = null) Adds a LEFT JOIN clause to the query using the CardToMap relation
 * @method     ChildCardQuery rightJoinCardToMap($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CardToMap relation
 * @method     ChildCardQuery innerJoinCardToMap($relationAlias = null) Adds a INNER JOIN clause to the query using the CardToMap relation
 *
 * @method     ChildCardQuery joinWithCardToMap($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CardToMap relation
 *
 * @method     ChildCardQuery leftJoinWithCardToMap() Adds a LEFT JOIN clause and with to the query using the CardToMap relation
 * @method     ChildCardQuery rightJoinWithCardToMap() Adds a RIGHT JOIN clause and with to the query using the CardToMap relation
 * @method     ChildCardQuery innerJoinWithCardToMap() Adds a INNER JOIN clause and with to the query using the CardToMap relation
 *
 * @method     \MapRec\MapRecBundle\Model\CardToMapQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCard findOne(ConnectionInterface $con = null) Return the first ChildCard matching the query
 * @method     ChildCard findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCard matching the query, or a new ChildCard object populated from the query conditions when no match is found
 *
 * @method     ChildCard findOneByCardId(int $card_id) Return the first ChildCard filtered by the card_id column
 * @method     ChildCard findOneByCardName(string $card_name) Return the first ChildCard filtered by the card_name column
 * @method     ChildCard findOneByRequiredCount(int $required_count) Return the first ChildCard filtered by the required_count column *

 * @method     ChildCard requirePk($key, ConnectionInterface $con = null) Return the ChildCard by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCard requireOne(ConnectionInterface $con = null) Return the first ChildCard matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCard requireOneByCardId(int $card_id) Return the first ChildCard filtered by the card_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCard requireOneByCardName(string $card_name) Return the first ChildCard filtered by the card_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCard requireOneByRequiredCount(int $required_count) Return the first ChildCard filtered by the required_count column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCard[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCard objects based on current ModelCriteria
 * @method     ChildCard[]|ObjectCollection findByCardId(int $card_id) Return ChildCard objects filtered by the card_id column
 * @method     ChildCard[]|ObjectCollection findByCardName(string $card_name) Return ChildCard objects filtered by the card_name column
 * @method     ChildCard[]|ObjectCollection findByRequiredCount(int $required_count) Return ChildCard objects filtered by the required_count column
 * @method     ChildCard[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CardQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MapRec\MapRecBundle\Model\Base\CardQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\MapRec\\MapRecBundle\\Model\\Card', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCardQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCardQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCardQuery) {
            return $criteria;
        }
        $query = new ChildCardQuery();
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
     * @return ChildCard|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CardTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CardTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildCard A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT card_id, card_name, required_count FROM card WHERE card_id = :p0';
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
            /** @var ChildCard $obj */
            $obj = new ChildCard();
            $obj->hydrate($row);
            CardTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildCard|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCardQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CardTableMap::COL_CARD_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCardQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CardTableMap::COL_CARD_ID, $keys, Criteria::IN);
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
     * @param     mixed $cardId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCardQuery The current query, for fluid interface
     */
    public function filterByCardId($cardId = null, $comparison = null)
    {
        if (is_array($cardId)) {
            $useMinMax = false;
            if (isset($cardId['min'])) {
                $this->addUsingAlias(CardTableMap::COL_CARD_ID, $cardId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cardId['max'])) {
                $this->addUsingAlias(CardTableMap::COL_CARD_ID, $cardId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CardTableMap::COL_CARD_ID, $cardId, $comparison);
    }

    /**
     * Filter the query on the card_name column
     *
     * Example usage:
     * <code>
     * $query->filterByCardName('fooValue');   // WHERE card_name = 'fooValue'
     * $query->filterByCardName('%fooValue%', Criteria::LIKE); // WHERE card_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cardName The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCardQuery The current query, for fluid interface
     */
    public function filterByCardName($cardName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cardName)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CardTableMap::COL_CARD_NAME, $cardName, $comparison);
    }

    /**
     * Filter the query on the required_count column
     *
     * Example usage:
     * <code>
     * $query->filterByRequiredCount(1234); // WHERE required_count = 1234
     * $query->filterByRequiredCount(array(12, 34)); // WHERE required_count IN (12, 34)
     * $query->filterByRequiredCount(array('min' => 12)); // WHERE required_count > 12
     * </code>
     *
     * @param     mixed $requiredCount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCardQuery The current query, for fluid interface
     */
    public function filterByRequiredCount($requiredCount = null, $comparison = null)
    {
        if (is_array($requiredCount)) {
            $useMinMax = false;
            if (isset($requiredCount['min'])) {
                $this->addUsingAlias(CardTableMap::COL_REQUIRED_COUNT, $requiredCount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($requiredCount['max'])) {
                $this->addUsingAlias(CardTableMap::COL_REQUIRED_COUNT, $requiredCount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CardTableMap::COL_REQUIRED_COUNT, $requiredCount, $comparison);
    }

    /**
     * Filter the query by a related \MapRec\MapRecBundle\Model\CardToMap object
     *
     * @param \MapRec\MapRecBundle\Model\CardToMap|ObjectCollection $cardToMap the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCardQuery The current query, for fluid interface
     */
    public function filterByCardToMap($cardToMap, $comparison = null)
    {
        if ($cardToMap instanceof \MapRec\MapRecBundle\Model\CardToMap) {
            return $this
                ->addUsingAlias(CardTableMap::COL_CARD_ID, $cardToMap->getCardId(), $comparison);
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
     * @return $this|ChildCardQuery The current query, for fluid interface
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
     * @param   ChildCard $card Object to remove from the list of results
     *
     * @return $this|ChildCardQuery The current query, for fluid interface
     */
    public function prune($card = null)
    {
        if ($card) {
            $this->addUsingAlias(CardTableMap::COL_CARD_ID, $card->getCardId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the card table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CardTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CardTableMap::clearInstancePool();
            CardTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CardTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CardTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CardTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CardTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CardQuery
