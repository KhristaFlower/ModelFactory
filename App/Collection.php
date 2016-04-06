<?php
/**
 * Created by PhpStorm.
 * User: Kriptonic
 * Date: 06/04/2016
 * Time: 23:05
 */

namespace App;

use App\Record;

/**
 * Class Collection
 *
 * @package App
 */
class Collection implements \ArrayAccess
{

    /** @var Record[] The models that this collection currently contains. */
    private $models = [];

    /** @var string The name of the class that this collection contains. */
    private $modelClass;

    public function __construct(string $modelClass)
    {
        $this->modelClass = $modelClass;
    }

    /**
     * Add a model to the collection.
     *
     * @param \App\Record $model
     * @throws \Exception
     */
    public function add(Record $model) {

        if (!$model instanceof $this->modelClass) {
            throw new \Exception("Can't put that in this collection!");
        }

        $this->models[] = $model;

    }

    /**
     * Call the provided method passing each model object to it.
     *
     * @param $callable
     * @return $this
     */
    public function each($callable) {

        foreach ($this->models as $model) {
            $callable($model);
        }

        return $this;

    }

    /**
     * Get the number of models in this collection.
     *
     * @return mixed
     */
    public function count() {
        return count($this->models);
    }

    public function get($index) {
        return $this->models[$index];
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return isset($this->models[$offset]);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return isset($this->models[$offset]) ? $this->models[$offset] : null;
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->models[$offset] = $value;
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->models[$offset]);
    }
}
