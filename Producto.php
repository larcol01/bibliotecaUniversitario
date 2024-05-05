
<?php

class Producto
{
    /* Propiedades del objeto producto */
    private $titulo;
    private $precio;
    private $cantidad;

    /* Constructor */
    public function __construct($isbn, $titulo, $idioma,$nombreAutor,$numeroEjemplares,$ano,$tema,$nombreEditorial, $cantidad)
    {
        $this->isbn =$isbn;
        $this->titulo = $titulo;
        $this->idioma =$idioma;
        $this->nombreAutor =$nombreAutor;
        $this->numeroEjemplares =$numeroEjemplares;
        $this->ano =$ano;
        $this->tema =$tema;
        $this->nombreEditorial =$nombreEditorial;
        $this->cantidad = $cantidad;
        
       
    }
    
    /* GET/ SET ISBN */

    public function getIsbn()
    {
        return $this->isbn =$isbn;
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

    public function getIidioma()
    {
        return $this->idioma =$idioma;
    }

    public function setIdioma($idioma)
    {
       $this->idioma =$idioma;
    }
    
    
    /* GET/ SET NOMBRE AUTOR */

    public function getNombreAutor()
    {
        return $this->nombreAutor =$nombreAutor;
    }

    public function setNombreAutor($nombreAutor)
    {
        $this->nombreAutor =$nombreAutor;
    }

    /* GET/ SET NUMERO EJEMPLARES */

    public function getNumEjemplares()
    {
        return $this->numeroEjemplares =$numeroEjemplares;
    }

    public function setNumEjemplares($numeroEjemplares)
    {
        $this->numeroEjemplares =$numeroEjemplares;
    }
    
    /* GET/ SET AÑO */

    public function getAno()
    {
        return  $this->ano =$ano;
    }

    public function setAno($ano)
    {
       $this->ano =$ano;
    }
    
    /* GET/ SET TEMA */

    public function getTema()
    {
        return $this->tema =$tema;
    }

    public function setTema($tema)
    {
       $this->tema =$tema;
    }
    
    /* GET/ SET NOMBRE EDITORIAL */

    public function getNombreEditorial()
    {
        return $this->nombreEditorial =$nombreEditorial;
    }

    public function setNombreEditorial($tmea)
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
?>