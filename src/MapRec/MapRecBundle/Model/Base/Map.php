<?php

namespace MapRec\MapRecBundle\Model\Base;

use \Exception;
use \PDO;
use MapRec\MapRecBundle\Model\CardToMap as ChildCardToMap;
use MapRec\MapRecBundle\Model\CardToMapQuery as ChildCardToMapQuery;
use MapRec\MapRecBundle\Model\Map as ChildMap;
use MapRec\MapRecBundle\Model\MapQuery as ChildMapQuery;
use MapRec\MapRecBundle\Model\Map\CardToMapTableMap;
use MapRec\MapRecBundle\Model\Map\MapTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'map' table.
 *
 *
 *
 * @package    propel.generator.MapRec.MapRecBundle.Model.Base
 */
abstract class Map implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\MapRec\\MapRecBundle\\Model\\Map\\MapTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the map_id field.
     *
     * @var        int
     */
    protected $map_id;

    /**
     * The value for the map_name field.
     *
     * @var        string
     */
    protected $map_name;

    /**
     * The value for the map_level field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $map_level;

    /**
     * The value for the map_tier field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $map_tier;

    /**
     * The value for the map_layout field.
     *
     * Note: this column has a database default value of: 'X'
     * @var        string
     */
    protected $map_layout;

    /**
     * The value for the map_difficulty field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $map_difficulty;

    /**
     * The value for the map_tileset field.
     *
     * @var        string
     */
    protected $map_tileset;

    /**
     * The value for the map_description field.
     *
     * Note: this column has a database default value of: 'No Description Available'
     * @var        string
     */
    protected $map_description;

    /**
     * The value for the map_num_bosses field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $map_num_bosses;

    /**
     * @var        ObjectCollection|ChildCardToMap[] Collection to store aggregation of ChildCardToMap objects.
     */
    protected $collCardToMaps;
    protected $collCardToMapsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCardToMap[]
     */
    protected $cardToMapsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->map_level = 0;
        $this->map_tier = 0;
        $this->map_layout = 'X';
        $this->map_difficulty = 0;
        $this->map_description = 'No Description Available';
        $this->map_num_bosses = 0;
    }

    /**
     * Initializes internal state of MapRec\MapRecBundle\Model\Base\Map object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Map</code> instance.  If
     * <code>obj</code> is an instance of <code>Map</code>, delegates to
     * <code>equals(Map)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Map The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [map_id] column value.
     *
     * @return int
     */
    public function getMapId()
    {
        return $this->map_id;
    }

    /**
     * Get the [map_name] column value.
     *
     * @return string
     */
    public function getMapName()
    {
        return $this->map_name;
    }

    /**
     * Get the [map_level] column value.
     *
     * @return int
     */
    public function getMapLevel()
    {
        return $this->map_level;
    }

    /**
     * Get the [map_tier] column value.
     *
     * @return int
     */
    public function getMapTier()
    {
        return $this->map_tier;
    }

    /**
     * Get the [map_layout] column value.
     *
     * @return string
     */
    public function getMapLayout()
    {
        return $this->map_layout;
    }

    /**
     * Get the [map_difficulty] column value.
     *
     * @return int
     */
    public function getMapDifficulty()
    {
        return $this->map_difficulty;
    }

    /**
     * Get the [map_tileset] column value.
     *
     * @return string
     */
    public function getMapTileset()
    {
        return $this->map_tileset;
    }

    /**
     * Get the [map_description] column value.
     *
     * @return string
     */
    public function getMapDescription()
    {
        return $this->map_description;
    }

    /**
     * Get the [map_num_bosses] column value.
     *
     * @return int
     */
    public function getMapNumBosses()
    {
        return $this->map_num_bosses;
    }

    /**
     * Set the value of [map_id] column.
     *
     * @param int $v new value
     * @return $this|\MapRec\MapRecBundle\Model\Map The current object (for fluent API support)
     */
    public function setMapId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->map_id !== $v) {
            $this->map_id = $v;
            $this->modifiedColumns[MapTableMap::COL_MAP_ID] = true;
        }

        return $this;
    } // setMapId()

    /**
     * Set the value of [map_name] column.
     *
     * @param string $v new value
     * @return $this|\MapRec\MapRecBundle\Model\Map The current object (for fluent API support)
     */
    public function setMapName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->map_name !== $v) {
            $this->map_name = $v;
            $this->modifiedColumns[MapTableMap::COL_MAP_NAME] = true;
        }

        return $this;
    } // setMapName()

    /**
     * Set the value of [map_level] column.
     *
     * @param int $v new value
     * @return $this|\MapRec\MapRecBundle\Model\Map The current object (for fluent API support)
     */
    public function setMapLevel($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->map_level !== $v) {
            $this->map_level = $v;
            $this->modifiedColumns[MapTableMap::COL_MAP_LEVEL] = true;
        }

        return $this;
    } // setMapLevel()

    /**
     * Set the value of [map_tier] column.
     *
     * @param int $v new value
     * @return $this|\MapRec\MapRecBundle\Model\Map The current object (for fluent API support)
     */
    public function setMapTier($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->map_tier !== $v) {
            $this->map_tier = $v;
            $this->modifiedColumns[MapTableMap::COL_MAP_TIER] = true;
        }

        return $this;
    } // setMapTier()

    /**
     * Set the value of [map_layout] column.
     *
     * @param string $v new value
     * @return $this|\MapRec\MapRecBundle\Model\Map The current object (for fluent API support)
     */
    public function setMapLayout($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->map_layout !== $v) {
            $this->map_layout = $v;
            $this->modifiedColumns[MapTableMap::COL_MAP_LAYOUT] = true;
        }

        return $this;
    } // setMapLayout()

    /**
     * Set the value of [map_difficulty] column.
     *
     * @param int $v new value
     * @return $this|\MapRec\MapRecBundle\Model\Map The current object (for fluent API support)
     */
    public function setMapDifficulty($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->map_difficulty !== $v) {
            $this->map_difficulty = $v;
            $this->modifiedColumns[MapTableMap::COL_MAP_DIFFICULTY] = true;
        }

        return $this;
    } // setMapDifficulty()

    /**
     * Set the value of [map_tileset] column.
     *
     * @param string $v new value
     * @return $this|\MapRec\MapRecBundle\Model\Map The current object (for fluent API support)
     */
    public function setMapTileset($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->map_tileset !== $v) {
            $this->map_tileset = $v;
            $this->modifiedColumns[MapTableMap::COL_MAP_TILESET] = true;
        }

        return $this;
    } // setMapTileset()

    /**
     * Set the value of [map_description] column.
     *
     * @param string $v new value
     * @return $this|\MapRec\MapRecBundle\Model\Map The current object (for fluent API support)
     */
    public function setMapDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->map_description !== $v) {
            $this->map_description = $v;
            $this->modifiedColumns[MapTableMap::COL_MAP_DESCRIPTION] = true;
        }

        return $this;
    } // setMapDescription()

    /**
     * Set the value of [map_num_bosses] column.
     *
     * @param int $v new value
     * @return $this|\MapRec\MapRecBundle\Model\Map The current object (for fluent API support)
     */
    public function setMapNumBosses($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->map_num_bosses !== $v) {
            $this->map_num_bosses = $v;
            $this->modifiedColumns[MapTableMap::COL_MAP_NUM_BOSSES] = true;
        }

        return $this;
    } // setMapNumBosses()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->map_level !== 0) {
                return false;
            }

            if ($this->map_tier !== 0) {
                return false;
            }

            if ($this->map_layout !== 'X') {
                return false;
            }

            if ($this->map_difficulty !== 0) {
                return false;
            }

            if ($this->map_description !== 'No Description Available') {
                return false;
            }

            if ($this->map_num_bosses !== 0) {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : MapTableMap::translateFieldName('MapId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->map_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : MapTableMap::translateFieldName('MapName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->map_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : MapTableMap::translateFieldName('MapLevel', TableMap::TYPE_PHPNAME, $indexType)];
            $this->map_level = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : MapTableMap::translateFieldName('MapTier', TableMap::TYPE_PHPNAME, $indexType)];
            $this->map_tier = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : MapTableMap::translateFieldName('MapLayout', TableMap::TYPE_PHPNAME, $indexType)];
            $this->map_layout = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : MapTableMap::translateFieldName('MapDifficulty', TableMap::TYPE_PHPNAME, $indexType)];
            $this->map_difficulty = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : MapTableMap::translateFieldName('MapTileset', TableMap::TYPE_PHPNAME, $indexType)];
            $this->map_tileset = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : MapTableMap::translateFieldName('MapDescription', TableMap::TYPE_PHPNAME, $indexType)];
            $this->map_description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : MapTableMap::translateFieldName('MapNumBosses', TableMap::TYPE_PHPNAME, $indexType)];
            $this->map_num_bosses = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = MapTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\MapRec\\MapRecBundle\\Model\\Map'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MapTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildMapQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collCardToMaps = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Map::setDeleted()
     * @see Map::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(MapTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildMapQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(MapTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                MapTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->cardToMapsScheduledForDeletion !== null) {
                if (!$this->cardToMapsScheduledForDeletion->isEmpty()) {
                    \MapRec\MapRecBundle\Model\CardToMapQuery::create()
                        ->filterByPrimaryKeys($this->cardToMapsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->cardToMapsScheduledForDeletion = null;
                }
            }

            if ($this->collCardToMaps !== null) {
                foreach ($this->collCardToMaps as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[MapTableMap::COL_MAP_ID] = true;
        if (null !== $this->map_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . MapTableMap::COL_MAP_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(MapTableMap::COL_MAP_ID)) {
            $modifiedColumns[':p' . $index++]  = 'map_id';
        }
        if ($this->isColumnModified(MapTableMap::COL_MAP_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'map_name';
        }
        if ($this->isColumnModified(MapTableMap::COL_MAP_LEVEL)) {
            $modifiedColumns[':p' . $index++]  = 'map_level';
        }
        if ($this->isColumnModified(MapTableMap::COL_MAP_TIER)) {
            $modifiedColumns[':p' . $index++]  = 'map_tier';
        }
        if ($this->isColumnModified(MapTableMap::COL_MAP_LAYOUT)) {
            $modifiedColumns[':p' . $index++]  = 'map_layout';
        }
        if ($this->isColumnModified(MapTableMap::COL_MAP_DIFFICULTY)) {
            $modifiedColumns[':p' . $index++]  = 'map_difficulty';
        }
        if ($this->isColumnModified(MapTableMap::COL_MAP_TILESET)) {
            $modifiedColumns[':p' . $index++]  = 'map_tileset';
        }
        if ($this->isColumnModified(MapTableMap::COL_MAP_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'map_description';
        }
        if ($this->isColumnModified(MapTableMap::COL_MAP_NUM_BOSSES)) {
            $modifiedColumns[':p' . $index++]  = 'map_num_bosses';
        }

        $sql = sprintf(
            'INSERT INTO map (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'map_id':
                        $stmt->bindValue($identifier, $this->map_id, PDO::PARAM_INT);
                        break;
                    case 'map_name':
                        $stmt->bindValue($identifier, $this->map_name, PDO::PARAM_STR);
                        break;
                    case 'map_level':
                        $stmt->bindValue($identifier, $this->map_level, PDO::PARAM_INT);
                        break;
                    case 'map_tier':
                        $stmt->bindValue($identifier, $this->map_tier, PDO::PARAM_INT);
                        break;
                    case 'map_layout':
                        $stmt->bindValue($identifier, $this->map_layout, PDO::PARAM_STR);
                        break;
                    case 'map_difficulty':
                        $stmt->bindValue($identifier, $this->map_difficulty, PDO::PARAM_INT);
                        break;
                    case 'map_tileset':
                        $stmt->bindValue($identifier, $this->map_tileset, PDO::PARAM_STR);
                        break;
                    case 'map_description':
                        $stmt->bindValue($identifier, $this->map_description, PDO::PARAM_STR);
                        break;
                    case 'map_num_bosses':
                        $stmt->bindValue($identifier, $this->map_num_bosses, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setMapId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = MapTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getMapId();
                break;
            case 1:
                return $this->getMapName();
                break;
            case 2:
                return $this->getMapLevel();
                break;
            case 3:
                return $this->getMapTier();
                break;
            case 4:
                return $this->getMapLayout();
                break;
            case 5:
                return $this->getMapDifficulty();
                break;
            case 6:
                return $this->getMapTileset();
                break;
            case 7:
                return $this->getMapDescription();
                break;
            case 8:
                return $this->getMapNumBosses();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Map'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Map'][$this->hashCode()] = true;
        $keys = MapTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getMapId(),
            $keys[1] => $this->getMapName(),
            $keys[2] => $this->getMapLevel(),
            $keys[3] => $this->getMapTier(),
            $keys[4] => $this->getMapLayout(),
            $keys[5] => $this->getMapDifficulty(),
            $keys[6] => $this->getMapTileset(),
            $keys[7] => $this->getMapDescription(),
            $keys[8] => $this->getMapNumBosses(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collCardToMaps) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'cardToMaps';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'card_to_maps';
                        break;
                    default:
                        $key = 'CardToMaps';
                }

                $result[$key] = $this->collCardToMaps->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\MapRec\MapRecBundle\Model\Map
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = MapTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\MapRec\MapRecBundle\Model\Map
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setMapId($value);
                break;
            case 1:
                $this->setMapName($value);
                break;
            case 2:
                $this->setMapLevel($value);
                break;
            case 3:
                $this->setMapTier($value);
                break;
            case 4:
                $this->setMapLayout($value);
                break;
            case 5:
                $this->setMapDifficulty($value);
                break;
            case 6:
                $this->setMapTileset($value);
                break;
            case 7:
                $this->setMapDescription($value);
                break;
            case 8:
                $this->setMapNumBosses($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = MapTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setMapId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setMapName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setMapLevel($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setMapTier($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setMapLayout($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setMapDifficulty($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setMapTileset($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setMapDescription($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setMapNumBosses($arr[$keys[8]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\MapRec\MapRecBundle\Model\Map The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(MapTableMap::DATABASE_NAME);

        if ($this->isColumnModified(MapTableMap::COL_MAP_ID)) {
            $criteria->add(MapTableMap::COL_MAP_ID, $this->map_id);
        }
        if ($this->isColumnModified(MapTableMap::COL_MAP_NAME)) {
            $criteria->add(MapTableMap::COL_MAP_NAME, $this->map_name);
        }
        if ($this->isColumnModified(MapTableMap::COL_MAP_LEVEL)) {
            $criteria->add(MapTableMap::COL_MAP_LEVEL, $this->map_level);
        }
        if ($this->isColumnModified(MapTableMap::COL_MAP_TIER)) {
            $criteria->add(MapTableMap::COL_MAP_TIER, $this->map_tier);
        }
        if ($this->isColumnModified(MapTableMap::COL_MAP_LAYOUT)) {
            $criteria->add(MapTableMap::COL_MAP_LAYOUT, $this->map_layout);
        }
        if ($this->isColumnModified(MapTableMap::COL_MAP_DIFFICULTY)) {
            $criteria->add(MapTableMap::COL_MAP_DIFFICULTY, $this->map_difficulty);
        }
        if ($this->isColumnModified(MapTableMap::COL_MAP_TILESET)) {
            $criteria->add(MapTableMap::COL_MAP_TILESET, $this->map_tileset);
        }
        if ($this->isColumnModified(MapTableMap::COL_MAP_DESCRIPTION)) {
            $criteria->add(MapTableMap::COL_MAP_DESCRIPTION, $this->map_description);
        }
        if ($this->isColumnModified(MapTableMap::COL_MAP_NUM_BOSSES)) {
            $criteria->add(MapTableMap::COL_MAP_NUM_BOSSES, $this->map_num_bosses);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildMapQuery::create();
        $criteria->add(MapTableMap::COL_MAP_ID, $this->map_id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getMapId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getMapId();
    }

    /**
     * Generic method to set the primary key (map_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setMapId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getMapId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \MapRec\MapRecBundle\Model\Map (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setMapName($this->getMapName());
        $copyObj->setMapLevel($this->getMapLevel());
        $copyObj->setMapTier($this->getMapTier());
        $copyObj->setMapLayout($this->getMapLayout());
        $copyObj->setMapDifficulty($this->getMapDifficulty());
        $copyObj->setMapTileset($this->getMapTileset());
        $copyObj->setMapDescription($this->getMapDescription());
        $copyObj->setMapNumBosses($this->getMapNumBosses());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCardToMaps() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCardToMap($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setMapId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \MapRec\MapRecBundle\Model\Map Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('CardToMap' == $relationName) {
            return $this->initCardToMaps();
        }
    }

    /**
     * Clears out the collCardToMaps collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCardToMaps()
     */
    public function clearCardToMaps()
    {
        $this->collCardToMaps = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCardToMaps collection loaded partially.
     */
    public function resetPartialCardToMaps($v = true)
    {
        $this->collCardToMapsPartial = $v;
    }

    /**
     * Initializes the collCardToMaps collection.
     *
     * By default this just sets the collCardToMaps collection to an empty array (like clearcollCardToMaps());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCardToMaps($overrideExisting = true)
    {
        if (null !== $this->collCardToMaps && !$overrideExisting) {
            return;
        }

        $collectionClassName = CardToMapTableMap::getTableMap()->getCollectionClassName();

        $this->collCardToMaps = new $collectionClassName;
        $this->collCardToMaps->setModel('\MapRec\MapRecBundle\Model\CardToMap');
    }

    /**
     * Gets an array of ChildCardToMap objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildMap is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCardToMap[] List of ChildCardToMap objects
     * @throws PropelException
     */
    public function getCardToMaps(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCardToMapsPartial && !$this->isNew();
        if (null === $this->collCardToMaps || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCardToMaps) {
                // return empty collection
                $this->initCardToMaps();
            } else {
                $collCardToMaps = ChildCardToMapQuery::create(null, $criteria)
                    ->filterByMap($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCardToMapsPartial && count($collCardToMaps)) {
                        $this->initCardToMaps(false);

                        foreach ($collCardToMaps as $obj) {
                            if (false == $this->collCardToMaps->contains($obj)) {
                                $this->collCardToMaps->append($obj);
                            }
                        }

                        $this->collCardToMapsPartial = true;
                    }

                    return $collCardToMaps;
                }

                if ($partial && $this->collCardToMaps) {
                    foreach ($this->collCardToMaps as $obj) {
                        if ($obj->isNew()) {
                            $collCardToMaps[] = $obj;
                        }
                    }
                }

                $this->collCardToMaps = $collCardToMaps;
                $this->collCardToMapsPartial = false;
            }
        }

        return $this->collCardToMaps;
    }

    /**
     * Sets a collection of ChildCardToMap objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $cardToMaps A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildMap The current object (for fluent API support)
     */
    public function setCardToMaps(Collection $cardToMaps, ConnectionInterface $con = null)
    {
        /** @var ChildCardToMap[] $cardToMapsToDelete */
        $cardToMapsToDelete = $this->getCardToMaps(new Criteria(), $con)->diff($cardToMaps);


        $this->cardToMapsScheduledForDeletion = $cardToMapsToDelete;

        foreach ($cardToMapsToDelete as $cardToMapRemoved) {
            $cardToMapRemoved->setMap(null);
        }

        $this->collCardToMaps = null;
        foreach ($cardToMaps as $cardToMap) {
            $this->addCardToMap($cardToMap);
        }

        $this->collCardToMaps = $cardToMaps;
        $this->collCardToMapsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CardToMap objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CardToMap objects.
     * @throws PropelException
     */
    public function countCardToMaps(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCardToMapsPartial && !$this->isNew();
        if (null === $this->collCardToMaps || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCardToMaps) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCardToMaps());
            }

            $query = ChildCardToMapQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMap($this)
                ->count($con);
        }

        return count($this->collCardToMaps);
    }

    /**
     * Method called to associate a ChildCardToMap object to this object
     * through the ChildCardToMap foreign key attribute.
     *
     * @param  ChildCardToMap $l ChildCardToMap
     * @return $this|\MapRec\MapRecBundle\Model\Map The current object (for fluent API support)
     */
    public function addCardToMap(ChildCardToMap $l)
    {
        if ($this->collCardToMaps === null) {
            $this->initCardToMaps();
            $this->collCardToMapsPartial = true;
        }

        if (!$this->collCardToMaps->contains($l)) {
            $this->doAddCardToMap($l);

            if ($this->cardToMapsScheduledForDeletion and $this->cardToMapsScheduledForDeletion->contains($l)) {
                $this->cardToMapsScheduledForDeletion->remove($this->cardToMapsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildCardToMap $cardToMap The ChildCardToMap object to add.
     */
    protected function doAddCardToMap(ChildCardToMap $cardToMap)
    {
        $this->collCardToMaps[]= $cardToMap;
        $cardToMap->setMap($this);
    }

    /**
     * @param  ChildCardToMap $cardToMap The ChildCardToMap object to remove.
     * @return $this|ChildMap The current object (for fluent API support)
     */
    public function removeCardToMap(ChildCardToMap $cardToMap)
    {
        if ($this->getCardToMaps()->contains($cardToMap)) {
            $pos = $this->collCardToMaps->search($cardToMap);
            $this->collCardToMaps->remove($pos);
            if (null === $this->cardToMapsScheduledForDeletion) {
                $this->cardToMapsScheduledForDeletion = clone $this->collCardToMaps;
                $this->cardToMapsScheduledForDeletion->clear();
            }
            $this->cardToMapsScheduledForDeletion[]= clone $cardToMap;
            $cardToMap->setMap(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Map is new, it will return
     * an empty collection; or if this Map has previously
     * been saved, it will retrieve related CardToMaps from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Map.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCardToMap[] List of ChildCardToMap objects
     */
    public function getCardToMapsJoinCard(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCardToMapQuery::create(null, $criteria);
        $query->joinWith('Card', $joinBehavior);

        return $this->getCardToMaps($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->map_id = null;
        $this->map_name = null;
        $this->map_level = null;
        $this->map_tier = null;
        $this->map_layout = null;
        $this->map_difficulty = null;
        $this->map_tileset = null;
        $this->map_description = null;
        $this->map_num_bosses = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collCardToMaps) {
                foreach ($this->collCardToMaps as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collCardToMaps = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(MapTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
