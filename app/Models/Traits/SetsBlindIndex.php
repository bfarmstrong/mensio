<?php

namespace App\Models\Traits;

/**
 * Sets a blind index column value based on another column's raw value.  Will
 * work against any value but is best used against an encrypted value.
 *
 * @example
 *
 * class User extends Model
 * {
 *     use Encryptable;
 *     use SetsBlindIndex;
 *
 *     protected $encrypts = ['name'];
 *     protected $blindIndex = 'name_bidx';
 *     protected $blindIndexed = 'name';
 * }
 */
trait SetsBlindIndex
{
    /**
     * Whenever the instance is saved, compute a new blind index.
     *
     * @return void
     */
    protected static function bootSetsBlindIndex()
    {
        static::saving(function ($instance) {
			foreach($instance->getBlindIndexColumn()  as $key => $column){
				$indexedColumn = $instance->getBlindIndexedColumn()[$key];
				$instance[$column] =  $instance->getBlindIndex($instance[$indexedColumn]);
			
			}
        });
    }

    /**
     * Returns the blind index from a static perspective.
     *
     * @param string $plaintext
     *
     * @return string
     */
    public static function getSearchIndex(string $plaintext)
    {
        $entity = new static();

        return $entity->getBlindIndex($plaintext);
    }

    /**
     * Returns the column that the blind index is saved to.
     *
     * @return string
     */
    public function getBlindIndexColumn()
    {
        return $this->blindIndex;
    }

    /**
     * Returns the column that the blind index is calculated against.
     *
     * @return string
     */
    protected function getBlindIndexedColumn()
    {
        return $this->blindIndexed;
    }

    /**
     * Returns the hashing algorithm to use for the blind index.
     *
     * @return string
     */
    protected function getBlindIndexHashAlgorithm()
    {
        return 'sha256';
    }

    /**
     * Returns the blind index based on the plaintext.
     *
     * @param string $plaintext
     *
     * @return string
     */
    protected function getBlindIndex(string $plaintext)
    {
        return hash(
            $this->getBlindIndexHashAlgorithm(),
            $plaintext
        );
    }
}
