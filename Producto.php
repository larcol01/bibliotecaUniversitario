
<?php

class Producto
{
    /* Propiedades del objeto producto */ 
    private $cantidad;
    private $isbn;
    private $titulo;
    private $idioma;
    private $nombreAutor;
    private $ano;
    private $tema;
    private $nombreEditorial;
    
    


    /* Constructor */
    public function _construct($cantidad, $isbn, $titulo, $idioma, $nombreAutor, $ano, $tema, $nombreEditorial)
    {  
        $this->cantidad = $cantidad;
        $this->isbn =$isbn;
        $this->titulo = $titulo;
        $this->idioma =$idioma;
        $this->nombreAutor =$nombreAutor;
        $this->ano =$ano;
        $this->tema =$tema;
        $this->nombreEditorial =$nombreEditorial;
      
        
       
    }
    
    /* GET/ SET ISBN */

    public function getIsbn()
    {
        return $this->isbn;
    }

    public function setIsbn($isbn)
    {
        $this->isbn =$isbn;
    }
    
    /* GET/ SET TITULO */

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }
    
    /* GET/ SET IDIOMA */

    public function getIdioma()
    {
       
        return $this->idioma ;
    }

    public function setIdioma($idioma)
    {
       $this->idioma =$idioma;
    }
    
    
    /* GET/ SET NOMBRE AUTOR */

    public function getNombreAutor()
    {
        /* @var $nombreAutor type */
        return $this->nombreAutor ;
    }

    public function setNombreAutor($nombreAutor)
    {
        $this->nombreAutor =nombreAutor;
    }

    
    /* GET/ SET AÑO */

    public function getAno()
    {
        /* @var $ano type */
        return  $this->ano;
    }

    public function setAno($ano)
    {
       $this->ano =$ano;
    }
    
    /* GET/ SET TEMA */

    public function getTema()
    {
        /* @var $tema type */
        return $this->tema ;
    }

    public function setTema($tema)
    {
       $this->tema =$tema;
    }
    
    /* GET/ SET NOMBRE EDITORIAL */

    public function getNombreEditorial()
    {
        
        /* @var $nombreEditorial type */
        return $this->nombreEditorial;
    }

    public function setNombreEditorial($nombreEditorial)
    {
       $this->nombreEditorial =$nombreEditorial;
    }
    
    /* GET/ SET CANTIDAD */

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

}
