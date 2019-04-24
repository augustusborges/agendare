<?php
    require_once BASE_DIR. 'dao' . DS . 'empresaDao.php';

    class empresa{
        
        public function getListaEmpresas(){
            return listaEmpresa();
        }
    }





?>