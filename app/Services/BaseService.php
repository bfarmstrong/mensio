<?php

namespace App\Services;

use App\Services\Criteria\Criteria;
use App\Services\Criteria\ICriteria;
use Illuminate\Container\Container;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

/**
 * Base implementation for a service.
 */
abstract class BaseService implements IBaseService, ICriteria
{
    /**
     * The container instance that is used to create the model.
     *
     * @var Container
     */
    private $container;

    /**
     * A collection of criteria currently saved to a service.
     *
     * @var Collection
     */
    protected $criteria;

    /**
     * The model instance that is created by the container.
     *
     * @var Model
     */
    protected $model;

    /**
     * Whether or not the next "find" query throws an exception.
     *
     * @var bool
     */
    protected $optional;

    /**
     * Whether the next query will skip the criteria.
     *
     * @var bool
     */
    protected $skipCriteria = false;

    /**
     * The name of the table that this service accesses.
     *
     * @var string
     */
    protected $table;

    /**
     * Creates an instance of `BaseService`.
     *
     * @param Container $container
     */
    public function __construct(Container $container, Collection $criteria)
    {
        $this->container = $container;
        $this->criteria = $criteria;
        $this->init();
    }

    /**
     * This function will return the class that is the model.
     *
     * @return string
     */
    abstract public function model();

    /**
     * Initializes the model and sets it to the instance.
     *
     * @return Model
     */
    public function init()
    {
        $model = $this->container->make($this->model());
        $this->table = $model->getTable();

        return $this->model = $model->newQuery();
    }

    /**
     * Resets the scope so that criteria will be used again.
     *
     * @return $this
     */
    public function clearScope()
    {
        $this->skipCriteria(false);

        return $this;
    }

    /**
     * Sets the instance to skip criteria for the next query.
     *
     * @param bool $status
     *
     * @return $this
     */
    public function skipCriteria(bool $status = true)
    {
        $this->skipCriteria = $status;

        return $this;
    }

    /**
     * Returns the current collection of criteria.
     *
     * @return Collection
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * Helper function to run a query with a single criteria.
     *
     * @param Criteria $criteria
     *
     * @return $this
     */
    public function getByCriteria(Criteria $criteria)
    {
        $this->pushCriteria($criteria);
        $this->model = $criteria->apply($this->model, $this);
        $this->skipCriteria(true);

        return $this;
    }

    /**
     * Pushes a new criteria to the service.
     *
     * @param Criteria $criteria
     *
     * @return $this
     */
    public function pushCriteria(Criteria $criteria)
    {
        $this->criteria->push($criteria);

        return $this;
    }

    /**
     * Clears out the criteria list.
     *
     * @return $this
     */
    public function flushCriteria()
    {
        $this->criteria = $this->container->make(Collection::class);

        return $this;
    }

    /**
     * Resets the criteria list so that new criteria may be used.
     *
     * @return $this
     */
    public function resetCriteria()
    {
        $this->flushCriteria();
        $this->skipCriteria(false);
        $this->init();

        return $this;
    }

    /**
     * Applies all of the criteria within the collection of criteria.
     *
     * @return $this
     */
    public function applyCriteria()
    {
        if (true === $this->skipCriteria) {
            return $this;
        }

        foreach ($this->getCriteria() as $criteria) {
            if ($criteria instanceof Criteria) {
                $this->model = $criteria->apply($this->model, $this);
            }
        }

        return $this;
    }

    /**
     * Sets the optional parameter.
     *
     * @param bool $optional
     *
     * @return $this
     */
    public function optional(bool $optional = true)
    {
        $this->optional = $optional;

        return $this;
    }

    /**
     * Returns the list of all of the entities in a table.
     *
     * @return Collection
     */
    public function all()
    {
        $this->applyCriteria();
        $results = $this->model->get();
        $this->resetCriteria();

        return $results;
    }

    /**
     * Creates a new instance of an entity.  Returns the entity that is created.
     *
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * Removes an instance of an entity from the database.
     *
     * @param mixed $id
     *
     * @return int
     */
    public function delete($id)
    {
        $entity = $this->find($id);

        return $entity->delete();
    }

    /**
     * Returns an entity by their identifier.
     *
     * @param mixed $id
     *
     * @return Model
     */
    public function find($id)
    {
        // Short circuit if the passed value is already the model
        if (is_a($id, $this->model())) {
            if ($this->criteria->isEmpty()) {
                $this->resetCriteria();

                return $id;
            }
            $id = $id->id;
        }

        $this->applyCriteria();
        $entity = $this->optional ?
            $this->model->find($id) :
            $this->model->findOrFail($id);
        $this->resetCriteria();

        return $entity;
    }

    /**
     * Returns an entity by a specific column.
     *
     * @param mixed $field
     * @param mixed $value
     *
     * @return Model
     */
    public function findBy($field, $value = null)
    {
        $this->applyCriteria();

        if (is_array($field)) {
            $entity = $this->optional ?
                $this->model->where($field)->first() :
                $this->model->where($field)->firstOrFail();
        } else {
            $entity = $this->optional ?
                $this->model->where($field, $value)->first() :
                $this->model->where($field, $value)->firstOrFail();
        }

        $this->resetCriteria();

        return $entity;
    }

    /**
     * Returns a paginated list of a model.
     *
     * @param int $limit
     *
     * @return LengthAwarePaginator
     */
    public function paginate(int $limit = 15)
    {
        $this->applyCriteria();
        $results = $this->model->paginate($limit);
        $this->resetCriteria();

        return $results;
    }

    /**
     * Performs a search based on the columns of a table.  Paginates the
     * results.
     *
     * @param string $query
     *
     * @return LengthAwarePaginator
     */
    public function search(string $query)
    {
        $this->applyCriteria();
        $columns = Schema::getColumnListing($this->table);

        $this->model->where(function ($q) use ($columns, $query) {
            foreach ($columns as $attribute) {
                $q->orWhere($attribute, 'LIKE', "%$query%");
            }
        });

        $results = $this->model->paginate();
        $this->resetCriteria();

        return $results;
    }

    /**
     * Updates an entity.  Returns if the update was successful.
     *
     * @param mixed $id
     * @param array $attributes
     *
     * @return bool
     */
    public function update($id, array $attributes)
    {
        $entity = $this->find($id);
        $entity->fill($attributes);

        return $entity->save();
    }
}
