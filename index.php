<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
      try {
        $base= new PDO("mysql:host=localhost;dbname=prueba","root","");
        $base->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $base->exec("SET CHARACTER SET utf8");

        $regxpag=3;
        if (isset($_GET["pagina"])) {
          if ($_GET['pagina']==1) {
              header("location:index.php");
            }else {
              $pagina = $_GET['pagina'];
            }
          }else {
            $pagina=1;
          }
        $empieza= ($pagina-1)*$regxpag;

        $sql="SELECT id,nombre,apellido,direccion FROM datos_usuarios ";

        $resultado=$base->prepare($sql);
        $resultado->execute(array());

        $numfilas=$resultado->rowCount();

        $totalpag=ceil($numfilas/$regxpag);

        echo "Numero de registro encontrados:". $numfilas. "<br>";
        echo "Mostramos $regxpag registros por pagina <br>";
        echo "Mostrando la pagina $pagina de $totalpag <br><br>";


        $resultado->closeCursor();

        $sql_limite="SELECT id,nombre,apellido,direccion FROM datos_usuarios LIMIT $empieza,$regxpag";
        $resultado=$base->prepare($sql_limite);
        $resultado->execute(array());
        while ($registro= $resultado->fetch(PDO::FETCH_ASSOC)) {
            echo "ID: ". $registro['id']." Nombre del usuario: ".$registro['nombre']." Apellido del usuario: " .$registro['apellido']." Domicilio: ".$registro['direccion']."<br>";
          }

      } catch (\Exception $e) {
        echo $e->getMessage();
      }


      //--------------
      for ($i=1; $i <= $totalpag ; $i++) {
        echo "<a href='?pagina=" .$i. "'>".$i."</a> " ;
      }

     ?>
  </body>
</html>
