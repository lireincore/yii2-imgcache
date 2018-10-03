<?php

namespace LireinCore\Yii2ImgCache;

use Yii;
use yii\base\BaseObject;
use LireinCore\ImgCache\ImgCache as ImgCacheService;
use LireinCore\ImgCache\Exception\ConfigException;

class ImgCache extends BaseObject
{
    /**
     * @var array
     */
    public $config;

    /**
     * @var ImgCacheService
     */
    protected $imgcache;

    /**
     * ImgCache constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * @throws ConfigException
     */
    public function init()
    {
        parent::init();

        if (isset($this->config['srcdir'])) {
            $this->config['srcdir'] = Yii::getAlias($this->config['srcdir']);
        }
        if (isset($this->config['destdir'])) {
            $this->config['destdir'] = Yii::getAlias($this->config['destdir']);
        }
        if (isset($this->config['webdir'])) {
            $this->config['webdir'] = Yii::getAlias($this->config['webdir']);
        }
        if (isset($this->config['baseurl'])) {
            $this->config['baseurl'] = Yii::getAlias($this->config['baseurl']);
        }
        if (isset($this->config['plug'])) {
            if (isset($this->config['plug']['path'])) {
                $this->config['plug']['path'] = Yii::getAlias($this->config['plug']['path']);
            }
            if (isset($this->config['plug']['url'])) {
                $this->config['plug']['url'] = Yii::getAlias($this->config['plug']['url']);
            }
        }
        if (isset($this->config['presets'])) {
            foreach ($this->config['presets'] as $presetName => $preset) {
                if (isset($preset['srcdir'])) {
                    $this->config['presets'][$presetName]['srcdir'] = Yii::getAlias($preset['srcdir']);
                }
                if (isset($preset['destdir'])) {
                    $this->config['presets'][$presetName]['destdir'] = Yii::getAlias($preset['destdir']);
                }
                if (isset($preset['webdir'])) {
                    $this->config['presets'][$presetName]['webdir'] = Yii::getAlias($preset['webdir']);
                }
                if (isset($preset['baseurl'])) {
                    $this->config['presets'][$presetName]['baseurl'] = Yii::getAlias($preset['baseurl']);
                }
                if (isset($preset['plug'])) {
                    if (isset($preset['plug']['path'])) {
                        $this->config['presets'][$presetName]['plug']['path'] = Yii::getAlias($preset['plug']['path']);
                    }
                    if (isset($preset['plug']['url'])) {
                        $this->config['presets'][$presetName]['plug']['url'] = Yii::getAlias($preset['plug']['url']);
                    }
                }
                if (isset($preset['effects'])) {
                    foreach ($preset['effects'] as $ind => $effect) {
                        if ($effect['type'] == 'overlay') {
                            if (isset($effect['params']['path'])) {
                                $this->config['presets'][$presetName]['effects'][$ind]['params']['path'] = Yii::getAlias($effect['params']['path']);
                            }
                        } elseif ($effect['type'] == 'text') {
                            if (isset($effect['params']['font'])) {
                                $this->config['presets'][$presetName]['effects'][$ind]['params']['font'] = Yii::getAlias($effect['params']['font']);
                            }
                        }
                    }
                }
            }
        }

        $this->imgcache = new ImgCacheService($this->config);
    }

    /**
     * @param string $srcRelPath relative path to source image
     * @param string|array $preset preset name or dynamic preset definition
     * @param bool $absolute
     * @param bool $useStub
     * @return string
     * @throws ConfigException
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function url($srcRelPath, $preset, $absolute = false, $useStub = true)
    {
        $srcRelPath = Yii::getAlias($srcRelPath);

        return $this->imgcache->url($srcRelPath, $preset, $absolute, $useStub);
    }

    /**
     * @param string $srcRelPath relative path to source image
     * @param string|array $preset preset name or dynamic preset definition
     * @param bool $useStub
     * @return string
     * @throws ConfigException
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function path($srcRelPath, $preset, $useStub = true)
    {
        $srcRelPath = Yii::getAlias($srcRelPath);

        return $this->imgcache->path($srcRelPath, $preset, $useStub);
    }

    /**
     * @param string|array $preset preset name or dynamic preset definition
     * @param bool $absolute
     * @return string
     * @throws ConfigException
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function stubUrl($preset, $absolute = false)
    {
        return $this->imgcache->stubUrl($preset, $absolute);
    }

    /**
     * @param string|array $preset preset name or dynamic preset definition
     * @return string
     * @throws ConfigException
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function stubPath($preset)
    {
        return $this->imgcache->stubPath($preset);
    }

    /**
     * @param string|array|null $preset preset name or dynamic preset definition
     * @throws ConfigException
     */
    public function clearCache($preset = null)
    {
        $this->imgcache->clearCache($preset);
    }
}