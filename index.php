

<?php
    
    $weather = "";
    $error = "";
    
    if (array_key_exists('city', $_GET)) {
        
        $city = str_replace(' ', '', $_GET['city']);
        $city = strtolower($city);
        $city = ucwords($city);
        
        $file_headers = @get_headers("http://www.weather-forecast.com/locations/".$city."/forecasts/latest");
        
        
        if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
    
            $error = "That city could not be found.";

        } else {
        
        $forecastPage = file_get_contents("http://www.weather-forecast.com/locations/".$city."/forecasts/latest");
        
        $pageArray = explode('(1&ndash;3 days)</div><p class="b-forecast__table-description-content"><span class="phrase">', $forecastPage);
            
        if (sizeof($pageArray) > 1) {
        
                $secondPageArray = explode('</span></p></td><td class="b-forecast__table-description-cell--js" colspan="9"><div class="b-forecast__table-description-title"><h2>'.$city.' Weather (4&ndash;7 days)</h2></div><p class="b-forecast__table-description-content"><span class="phrase">', $pageArray[1]);
            
                if (sizeof($secondPageArray) > 1) {

                    $weather = $secondPageArray[0];
                    
                } else {
                    
                    $error = "That city could not be found.";
                    
                }
            
            } else {
            
                $error = "That city could not be found.";
            
            }
        
        }
        
    }


?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <title>Weather Forecast</title>
    <style>
      html { 
  background: url(forest.jpg) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
     body {
    background : none ;
}

.container{
    text-align: center;
    margin-top: 200px;
    width: 500px;
    color: white ;
}
input {
    margin: 20px 20px;
}
#weather {
              
              margin-top:15px;
              
          }
</style>
  </head>
  <body>
<div class="container">
<h1>Weather Forcaster </h1>
<h4> Enter the name of a city -:</h4>

<form>
  <div class="form-group row">
    <div class="col-sm-10">
      <input type="text" class="form-control" name="city" id="city" placeholder="Eg . Mumbai,Delhi" value = "<?php 
																										   
																										   if (array_key_exists('city', $_GET)) {
																										   
																										   echo $_GET['city']; 
																										   
																										   }
																										   
																										   ?>">
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-10">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>
</form>
<div id="weather"><?php 
              
              if ($weather) {
                  
                  echo '<div class="alert alert-success" role="alert">
  '.$weather.'
</div>';
                  
              } else if ($error) {
                  
                  echo '<div class="alert alert-danger" role="alert">
  '.$error.'
</div>';
                  
              }
              
              ?></div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

  </body>
</html>