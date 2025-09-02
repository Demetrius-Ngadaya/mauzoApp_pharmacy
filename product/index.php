<?php
 
    session_start();

    if(!isset($_SESSION['user_session'])){

        header("location:../index.php");
    }
?>
<body>
<form method="POST" action="register.php">
  	  	  <table id="table" style="width: 400px; margin: auto;overflow-x:auto; overflow-y: auto;">
  	  	 <tr>
         <td>Jina la mtumiaji:</td>
         <td><input type="text" name="user_name" id="user_name" size="10" placeholder="Jina" required></td>
          </tr>
          <tr id="row1">
         <td>Neno sili la mtumiaji:</td>
         <td><input type="password" name="password"  id="password" size="10" placeholder="Neno la sili"required ></td>
        </tr>
        <tr>        

        <tr>
          <td></td>
          <td> <input type="submit" name="submit" class="btn btn-success btn-large" style="width: 225px" value="Save"> </td>
        </tr>

  	  	 </table> 
        <br>
  	  	 </form><br>
</body>
     
  </script> -->
</html>
