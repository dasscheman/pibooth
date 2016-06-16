<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Feest Josje & Daan';
?>
<div class="site-index">

    <div class="jumbotron">
      <h1>Afterparty!</h1>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-push-10">
                <div class="transbox">
                  <div class="transbox-text">
                    <h3>Dank!</h3>
                    <p>
                        Inmiddels hebben wij een nacht van bijna 12 uur geslapen en hebben thuis bijna alle spullen opgeruimd. 
                        
                        Wij vonden het een heel tof feest en hebben genoten van jullie aanwezigheid. 
                        Wij willen jullie bedanken voor jullie aanwezigheid en cadeau's.
                        Verder willen we iedereen bedanken die geholpen heeft bij het opbouwen, maar ook bij het afbreken zondag. Jullie zijn geweldig!
                    </p>
                    
                    <h3>Foto's</h3>
                    <p>
                          Wij zouden het leuk vinden om heel veel foto's te hebben van ons feest.
                          En het liefst foto's door de ogen van onze gasten.
                          Een aantal van jullie hebben tijdens het feest al foto's geupload naar de site van foto.feest, dank daarvoor. 
                          Maar jullie kunnen nog steeds foto's uploaden op deze site. Dus ook de foto's die gemaakt zijn met een gewone camera kun je hier uploaden, het liefst ongecomprimeerd.

                    </p>
<!--                      <h2>Foto's</h2>

                      <p>Wij zouden het leuk vinden om heel veel foto's te hebben van ons feest. 
                          En het liefst foto's door de ogen van onze gasten.
                          Daarom willen wij jullie vragen om foto's te maken en die hier te uploaden. 
                      </p>

                      <h3>Dit doe je als volgt:</h3>
                      <p>   
                          <ul>Log in op het wifi netwerk "Pi3-photobooth"</ul>
                          <ul>Het wachtwoord is "raspberry"</ul>
                          <ul>Ga met je browser naar <b><i>http://foto.feest</i></b> (zonder www)</ul>
                          <ul>Op deze site kun je je foto's uploaden</ul>
                          <br>
                          <h4>Let op!</h4> 
                          Zolang je met het netwerk "Pi3-photobooth" verbonden bent, heb je geen contact met het internet.
                          Heel handig, daardoor gebruik je niets van je data limieten bij het uploaden van foto's, maar je kunt ook niet internetten of whatsappen.
                      </p>-->
                  </div>
                </div>
            </div>
        </div>
    </div>
  
    <div class="jumbotron">
        <?php
        echo Html::a("Foto's bekijken",
            ['site/viewimages'],
            ['class' => 'btn btn-default']); ?>


      <?php
      echo Html::a("Nieuwe foto's upload",
          ['site/upload'],
          ['class' => 'btn btn-lg btn-primary']); ?>
    </div>
</div>
