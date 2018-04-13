<?php
use yii\helpers\Html;

/* $contador */
/* $jugadores */

foreach ($jugadores as $jugador): ?>
    <?php
      $activo = $contador == 0 ? 'active' : '';
      $contador++;
    ?>
    <div class="item <?=$activo?>">
      <?=Html::img($jugador->foto)?>
      <div class="carousel-caption">
            <h3><?= $jugador->nombre ?> </h3>
            <p><?= $jugador->posicion->nombre?></p>
        </div>
    </div>
<?php endforeach; ?>
