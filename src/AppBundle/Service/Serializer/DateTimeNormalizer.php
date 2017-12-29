<?php

declare(strict_types=1);

namespace AppBundle\Service\Serializer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

class DateTimeNormalizer implements NormalizerInterface, DenormalizerInterface
{
    use SerializerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        $datetime = new \DateTime();
        $datetime->setTimestamp($data);

        return $datetime;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === 'DateTime';
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        if (!($object instanceof \DateTimeInterface)) {
            throw new \InvalidArgumentException();
        }

        return $object->getTimestamp();
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return is_object($data) && ($data instanceof \DateTimeInterface);
    }
}
