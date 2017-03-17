<?php

namespace LireinCore\Yii2ImgCache;

use yii\base\Object;
use Yii;

class ImgCache extends Object
{
    /**
     * @var array
     */
    public $config;

    /**
     * @var \LireinCore\ImgCache\ImgCache
     */
    private $_imgcache;

    /**
     * ImgCache constructor.
     *
     * @param $config array|string|null
     */
    public function __construct($config = [])
    {
        $this->_imgcache = new \LireinCore\ImgCache\ImgCache();

        parent::__construct($config);
    }

    public function init()
    {
        parent::init();

        $config = $this->config;

        if (isset($this->config['srcdir'])) $config['srcdir'] = Yii::getAlias($this->config['srcdir']);
        if (isset($this->config['destdir'])) $config['destdir'] = Yii::getAlias($this->config['destdir']);
        if (isset($this->config['webdir'])) $config['webdir'] = Yii::getAlias($this->config['webdir']);
        if (isset($this->config['baseurl'])) $config['baseurl'] = Yii::getAlias($this->config['baseurl']);
        if (isset($this->config['plug'])) {
            if (isset($this->config['plug']['path'])) $config['plug']['path'] = Yii::getAlias($this->config['plug']['path']);
        }
        if (isset($this->config['presets'])) {
            foreach ($this->config['presets'] as $presetName => $preset) {
                if (isset($preset['srcdir'])) $config['presets'][$presetName]['srcdir'] = Yii::getAlias($preset['srcdir']);
                if (isset($preset['destdir'])) $config['presets'][$presetName]['destdir'] = Yii::getAlias($preset['destdir']);
                if (isset($preset['webdir'])) $config['presets'][$presetName]['webdir'] = Yii::getAlias($preset['webdir']);
                if (isset($preset['baseurl'])) $config['presets'][$presetName]['baseurl'] = Yii::getAlias($preset['baseurl']);
                if (isset($preset['plug'])) {
                    if (isset($preset['plug']['path'])) $config['presets'][$presetName]['plug']['path'] = Yii::getAlias($preset['plug']['path']);
                }
                if (isset($preset['effects'])) {
                    foreach ($preset['effects'] as $ind => $effect) {
                        if ($effect['type'] == 'overlay') {
                            if (isset($effect['params']['path'])) $config['presets'][$presetName]['effects'][$ind]['params']['path'] = Yii::getAlias($effect['params']['path']);
                        }
                    }
                }
            }
        }

        $this->_imgcache->setConfig($config);
    }

    /**
     * @param string $name
     * @param string $class
     */
    public function registerEffect($name, $class)
    {
        $this->_imgcache->registerEffect($name, $class);
    }

    /**
     * @param string $name
     */
    public function unregisterEffect($name)
    {
        $this->_imgcache->unregisterEffect($name);
    }

    /**
     * @return array
     */
    public function getEffects()
    {
        return $this->_imgcache->getEffects();
    }

    /**
     * @param string $presetName
     * @param string|null $fileRelPath
     * @param bool $usePlug
     * @return bool|string
     */
    public function path($presetName, $fileRelPath = null, $usePlug = true)
    {
        $fileRelPath = Yii::getAlias($fileRelPath);
        return $this->_imgcache->path($presetName, $fileRelPath, $usePlug);
    }

    /**
     * @param string|null $presetName
     * @param string|null $fileRelPath
     * @param bool $absolute
     * @param bool $usePlug
     * @return bool|string
     */
    public function url($presetName = null, $fileRelPath = null, $absolute = false, $usePlug = true)
    {
        $fileRelPath = Yii::getAlias($fileRelPath);
        return $this->_imgcache->url($presetName, $fileRelPath, $absolute, $usePlug);
    }

    /**
     * @param string $fileRelPath
     * @param string|null $presetName
     */
    public function clearFileThumbs($fileRelPath, $presetName = null)
    {
        $fileRelPath = Yii::getAlias($fileRelPath);
        $this->_imgcache->clearFileThumbs($fileRelPath, $presetName);
    }

    /**
     * @param string $presetName
     */
    public function clearPresetThumbs($presetName)
    {
        $this->_imgcache->clearFileThumbs($presetName);
    }

    /**
     * @param string|null $presetName
     */
    public function clearPlugsThumbs($presetName = null)
    {
        $this->_imgcache->clearPlugsThumbs($presetName);
    }
}