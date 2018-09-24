<?php

namespace App\Models\Traits;

/**
 * Signable.
 *
 * Adds the ability to a model to handle digital signatures.
 *
 * Usage:
 *
 *   - Add a protected $signable variable to your model class, fill it with the
 *     names of columns that should be added to the signature.
 *   - Add an override for the public function getSignee which returns the
 *     identity of the signee.  Example being the users model you could return
 *     the uuid.
 *   - Optional: add an override for the public function getSignatureColumnOption
 *     which returns the name of the column that the signature will save to.
 *   - Optional: add an override for the public function getHashAlgorithmOption
 *     to change the hash algorithm that is used.  It currently defaults to
 *     sha256.
 *
 * Whenever the model is saved to the database the digital signature will be
 * recalculated and saved to the database as well.  The signature can then be
 * validated against a signee by calling the function isSignatureValid and
 * passing a signee value.
 */
trait Signable
{
    /**
     * Creates a hook which signs the instance whenever it is saved.
     *
     * @return void
     */
    protected static function bootSignable()
    {
        static::saving(function ($instance) {
            $instance[$instance->getSignatureColumnOption()] =
                $instance->getSignature($instance->getSignee());
        });
    }

    /**
     * Returns the hashing algorithm to use for signing.
     *
     * @return string
     */
    public function getHashAlgorithmOption()
    {
        return 'sha256';
    }

    /**
     * The column that the signature will be written to.
     *
     * @return string
     */
    public function getSignatureColumnOption()
    {
        return 'digital_signature';
    }

    /**
     * Returns the signee of a document.  The signee is added to the message
     * during the signing process.
     *
     * @return string
     */
    public function getSignee()
    {
        return '';
    }

    /**
     * Returns whether or not the provided signee signed the document and that
     * it is valid.
     *
     * @param string $signee
     *
     * @return bool
     */
    public function isSignatureValid(string $signee)
    {
        return $this->getHashedSignature($signee) === $this->getStoredSignatureHash();
    }

    /**
     * Magic method that allows you to reference the model as if it has a
     * `verified` attribute.  Returns if the signature is valid for the
     * signee.
     *
     * @return bool
     */
    public function getVerifiedAttribute()
    {
        return $this->isSignatureValid($this->getSignee());
    }

    /**
     * Returns the plaintext version of the signature.
     *
     * @param string $signee
     *
     * @return string
     */
    public function getPlaintextSignature(string $signee)
    {
        return collect($this->signable)->reduce(function ($carry, $item) {
            return $carry.$this[$item];
        }, $signee);
    }

    /**
     * Returns the hashed signature.
     *
     * @param string $signee
     *
     * @return string
     */
    public function getHashedSignature(string $signee)
    {
        return hash(
            $this->getHashAlgorithmOption(),
            $this->getPlaintextSignature($signee)
        );
    }

    /**
     * Returns the hashed and encrypted version of the signature.
     *
     * @param string $signee
     *
     * @return string
     */
    public function getSignature(string $signee)
    {
        return encrypt($this->getHashedSignature($signee));
    }

    /**
     * Returns the decrypted hash of the signature.
     *
     * @return string
     */
    public function getStoredSignatureHash()
    {
        return decrypt($this[$this->getSignatureColumnOption()]);
    }
}
