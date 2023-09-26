<?php
/**
 * Override controller AdminOrdersController
 * @author MAGES Michał Jendraszczyk
 * @copyright (c) 2019, MAGES Michał Jendraszczyk
 * @license http://mages.pl MAGES Michał Jendraszczyk
 */

class AdminOrdersController extends AdminOrdersControllerCore
{
    public function __construct()
    {
        parent::__construct();
        
        if (Configuration::get('mjordersdelete_enable') == '1') {
            $this->addRowAction('delete');
        }
    }

    public function initPageHeaderToolbar()
    {
        if (Configuration::get('mjordersdelete_enable') == '1') {
            if ($this->display == 'view') {
                $this->page_header_toolbar_btn['delete'] = array(
                    'href' => self::$currentIndex.'&id_order='.Tools::getValue('id_order').'&deleteorder&token='.$this->token,
                    'desc' => 'Delete order',
                    'icon' => 'process-icon-delete'
                );
            }
        }
        parent::initPageHeaderToolbar();
    }
}
