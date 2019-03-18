<?php

namespace LireinCore\Yii2ImgCache;

use Yii;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use LireinCore\ImgCache\ImgCache as ImgCacheService;
use LireinCore\ImgCache\Exception\ConfigException;

final class ImgCache
{
    /**
     * @var ImgCacheService
     */
    private $imgcache;

    /**
     * ImgCache constructor.
     *
     * @param array $config
     * @param null|LoggerInterface $logger
     * @param null|EventDispatcherInterface $eventDispatcher
     * @throws ConfigException
     */
    public function __construct(
        array $config,
        ?LoggerInterface $logger = null,
        ?EventDispatcherInterface $eventDispatcher = null
    )
    {
        if (isset($config['srcdir'])) {
            $config['srcdir'] = Yii::getAlias($config['srcdir']);
        }
        if (isset($config['destdir'])) {
            $config['destdir'] = Yii::getAlias($config['destdir']);
        }
        if (isset($config['webdir'])) {
            $config['webdir'] = Yii::getAlias($config['webdir']);
        }
        if (isset($config['baseurl'])) {
            $config['baseurl'] = Yii::getAlias($config['baseurl']);
        }
        if (isset($config['plug'])) {
            if (isset($config['plug']['path'])) {
                $config['plug']['path'] = Yii::getAlias($config['plug']['path']);
            }
            if (isset($config['plug']['url'])) {
                $config['plug']['url'] = Yii::getAlias($config['plug']['url']);
            }
        }
        if (isset($config['presets'])) {
            foreach ($config['presets'] as $presetName => &$preset) {
                $this->processPresetDefinition($preset);
            }
            unset($preset);
        }

        $this->imgcache = new ImgCacheService($config, $logger, $eventDispatcher);
    }

    /**
     * @param string $srcPath absolute or relative path to source image
     * @param string|array $preset preset name or dynamic preset definition
     * @param bool $absolute
     * @param bool $useStub
     * @return string
     * @throws ConfigException
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function url(string $srcPath, $preset, bool $absolute = false, bool $useStub = true) : string
    {
        $srcPath = Yii::getAlias($srcPath);

        if (\is_array($preset)) {
            $this->processPresetDefinition($preset);
        }

        return $this->imgcache->url($srcPath, $preset, $absolute, $useStub);
    }

    /**
     * @param string $srcPath absolute or relative path to source image
     * @param string|array $preset preset name or dynamic preset definition
     * @param bool $useStub
     * @return string
     * @throws ConfigException
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function path(string $srcPath, $preset, bool $useStub = true) : string
    {
        $srcPath = Yii::getAlias($srcPath);

        if (\is_array($preset)) {
            $this->processPresetDefinition($preset);
        }

        return $this->imgcache->path($srcPath, $preset, $useStub);
    }

    /**
     * @param string|array $preset preset name or dynamic preset definition
     * @param bool $absolute
     * @return string
     * @throws ConfigException
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function stubUrl($preset, bool $absolute = false) : string
    {
        if (\is_array($preset)) {
            $this->processPresetDefinition($preset);
        }

        return $this->imgcache->stubUrl($preset, $absolute);
    }

    /**
     * @param string|array $preset preset name or dynamic preset definition
     * @return string
     * @throws ConfigException
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function stubPath($preset) : string
    {
        if (\is_array($preset)) {
            $this->processPresetDefinition($preset);
        }

        return $this->imgcache->stubPath($preset);
    }

    /**
     * @param string|array|null $preset preset name or dynamic preset definition
     * @throws ConfigException
     */
    public function clearCache($preset = null) : void
    {
        if (\is_array($preset)) {
            $this->processPresetDefinition($preset);
        }

        $this->imgcache->clearCache($preset);
    }

    /**
     * @param array $preset dynamic preset definition
     */
    private function processPresetDefinition(array &$preset) : void
    {
        if (isset($preset['srcdir'])) {
            $preset['srcdir'] = Yii::getAlias($preset['srcdir']);
        }
        if (isset($preset['destdir'])) {
            $preset['destdir'] = Yii::getAlias($preset['destdir']);
        }
        if (isset($preset['webdir'])) {
            $preset['webdir'] = Yii::getAlias($preset['webdir']);
        }
        if (isset($preset['baseurl'])) {
            $preset['baseurl'] = Yii::getAlias($preset['baseurl']);
        }
        if (isset($preset['plug'])) {
            if (isset($preset['plug']['path'])) {
                $preset['plug']['path'] = Yii::getAlias($preset['plug']['path']);
            }
            if (isset($preset['plug']['url'])) {
                $preset['plug']['url'] = Yii::getAlias($preset['plug']['url']);
            }
        }
        if (isset($preset['effects'])) {
            foreach ($preset['effects'] as $ind => $effect) {
                if ($effect['type'] === 'overlay') {
                    if (isset($effect['params']['path'])) {
                        $preset['effects'][$ind]['params']['path'] = Yii::getAlias($effect['params']['path']);
                    }
                } elseif ($effect['type'] === 'text') {
                    if (isset($effect['params']['font'])) {
                        $preset['effects'][$ind]['params']['font'] = Yii::getAlias($effect['params']['font']);
                    }
                }
            }
        }
    }
}