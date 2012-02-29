<?php
/*
 * This file is part of FacturaSctipts
 * Copyright (C) 2012  Carlos Garcia Gomez  neorazorx@gmail.com
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once 'base/fs_model.php';

class factura_proveedor extends fs_model
{
   public $idfactura;
   public $idasiento;
   public $codigo;
   public $numero;
   public $numproveedor;
   public $codejercicio;
   public $codserie;
   public $fecha;
   public $codproveedor;
   public $nombre;
   public $cifnif;
   public $neto;
   public $totaliva;
   public $total;
   public $totaleuros;
   public $observaciones;
   
   public function __construct($f=FALSE)
   {
      parent::__construct('facturasprov');
      if($f)
      {
         $this->idfactura = $f['idfactura'];
         $this->idasiento = $f['idasiento'];
         $this->codigo = $f['codigo'];
         $this->numero = $f['numero'];
         $this->numproveedor = $f['numproveedor'];
         $this->codejercicio = $f['codejercicio'];
         $this->codserie = $f['codserie'];
         $this->fecha = $f['fecha'];
         $this->codproveedor = $f['codproveedor'];
         $this->nombre = $f['nombre'];
         $this->cifnif = $f['cifnif'];
         $this->neto = floatval($f['neto']);
         $this->totaliva = floatval($f['totaliva']);
         $this->total = floatval($f['total']);
         $this->totaleuros = floatval($f['totaleuros']);
         $this->observaciones = $f['observaciones'];
      }
      else
      {
         $this->idfactura = NULL;
         $this->idasiento = NULL;
         $this->codigo = '';
         $this->numero = '';
         $this->numproveedor = '';
         $this->codejercicio = NULL;
         $this->codserie = NULL;
         $this->fecha = Date('j-n-Y');
         $this->codproveedor = NULL;
         $this->nombre = '';
         $this->cifnif = '';
         $this->neto = 0;
         $this->totaliva = 0;
         $this->total = 0;
         $this->totaleuros = 0;
         $this->observaciones = '';
      }
   }
   
   public function url()
   {
      return '';
   }
   
   public function show_total()
   {
      return number_format($this->totaleuros, 2, ',', '.');
   }
   
   public function show_fecha()
   {
      return Date('j-n-Y', strtotime($this->fecha));
   }
   
   public function observaciones_resume()
   {
      if($this->observaciones == '')
         return '-';
      else if( strlen($this->observaciones) < 60 )
         return $this->observaciones;
      else
         return substr($this->observaciones, 0, 50).'...';
   }
   
   protected function install()
   {
      return '';
   }
   
   public function exists()
   {
      return $this->db->select("SELECT * FROM ".$this->table_name." WHERE idfactura = '".$this->idfactura."';");
   }
      
   public function save()
   {
      ;
   }
   
   public function delete()
   {
      return $this->db->exec("DELETE FROM ".$this->table_name." WHERE idfactura = '".$this->idfactura."';");
   }
   
   public function all($offset=0)
   {
      $faclist = array();
      $facturas = $this->db->select_limit("SELECT * FROM ".$this->table_name." ORDER BY idfactura DESC",
                                          FS_ITEM_LIMIT, $offset);
      if($facturas)
      {
         foreach($facturas as $f)
         {
            $fo = new factura_proveedor($f);
            $faclist[] = $fo;
         }
      }
      return $faclist;
   }
}

?>