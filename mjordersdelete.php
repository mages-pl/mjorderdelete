<?php
/**
 * Main class of module mjordersdelete
 * @author MAGES Michał Jendraszczyk
 * @copyright (c) 2019, MAGES Michał Jendraszczyk
 * @license http://mages.pl MAGES Michał Jendraszczyk
 */

class Mjordersdelete extends Module
{

    public $latestHidden;

    //  Inicjalizacja
    public function __construct()
    {
        $this->name = 'mjordersdelete';
        $this->tab = 'administration';
        $this->version = '1.00';
        $this->author = 'MAGES Michał Jendraszczyk';
        $this->module_key = 'eac87c122e62e749101e7ad8c8bdf8ee';

        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Orders Remove Prestashop');
        $this->description = $this->l('Very quickly remove orders from backoffice yours prestashop. It save you clean in yours administration panel.');

        $this->confirmUninstall = $this->l('Remove module');
    }

    //  Instalacja
    public function install()
    {
        parent::install();
        Configuration::updateValue('mjordersdelete_enable', '1');
        return true;
    }

    // Deinstalacja
    public function uninstall()
    {
        return parent::uninstall();
    }

    // Budowanie formularza
    public function renderForm()
    {
        $fields_form = array();
        $fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->l('Settings'),
            ),
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Enable remove option in orders'),
                    'size' => '5',
                    'name' => 'mjordersdelete_enable',
                    'is_bool' => true,
                    'required' => true,
                    'values' => array(
                        array(
                        'id' => 'mjordersdelete_enable_on',
                        'value' => 1,
                        'label' => $this->l('Enabled')
                        ),
                        array(
                        'id' => 'mjordersdelete_enable_off',
                        'value' => 0,
                        'label' => $this->l('Disabled')
                        )
                     ),
                    )
                ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right',
            ),
        );

        $form = new HelperForm();

        $form->token = Tools::getAdminTokenLite('AdminModules');
        $form->currentIndex = Tools::getHttpHost(true) . __PS_BASE_URI__ . basename(PS_ADMIN_DIR) . '/' . AdminController::$currentIndex . '&configure=' . $this->name . '&export=1';

        $form->tpl_vars['fields_value']['mjordersdelete_enable'] = Tools::getValue('mjordersdelete_enable', Configuration::get('mjordersdelete_enable'));

        return $form->generateForm($fields_form);
    }

    // Wyswietlenie contentu
    public function getContent()
    {
        return $this->postProcess() . $this->renderForm();
    }

    public function postProcess()
    {
        if (Tools::isSubmit('submitAddconfiguration')) :
            Configuration::updateValue('mjordersdelete_enable', Tools::getValue('mjordersdelete_enable'));
            
            return $this->displayConfirmation($this->l("Saved successfully!"));
        endif;
    }
}
