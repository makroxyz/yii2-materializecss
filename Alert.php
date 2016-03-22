<?php

namespace macgyer\yii2materializecss;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class Alert
 * @package macgyer\yii2materializecss
 */
class Alert extends Widget
{
    private $_defaultAlertLevels = [
        'error' => 'error',
        'danger' => 'danger',
        'success' => 'success',
        'info' => 'info',
        'warning' => 'warning'
    ];
    public $alertLevels = [];
    public $options = [];

    /**
     * initialize the widget
     */
    public function init()
    {
        parent::init();
        $this->alertLevels = ArrayHelper::merge($this->_defaultAlertLevels, $this->alertLevels);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $flashes = Yii::$app->session->getAllFlashes();
        $appendCss = isset($this->options['class']) ? ' ' . $this->options['class'] : '';

        foreach ($flashes as $type => $data) {
            if (isset($this->alertLevels[$type])) {
                $data = (array)$data;
                foreach ($data as $i => $message) {
                    /* initialize css class for each alert box */
                    $this->options['class'] = 'alert ' . $this->alertLevels[$type] . $appendCss;

                    /* assign unique id to each alert box */
                    $this->options['id'] = $this->getId() . '-' . $type . '-' . $i;

                    echo $this->renderHtml($message, $this->options);
                }

                Yii::$app->session->removeFlash($type);
            }
        }
    }

    /**
     * @param $message
     * @param array $options
     * @return string
     */
    private function renderHtml($message, $options = [])
    {
        return CardPanel::widget([
            'content' => $message,
            'options' => $this->options
        ]);
    }
}