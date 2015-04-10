<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Site */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$idProject = $model->proyek;
$model->proyek = $model->getProject($idProject);

?>
<div class="site-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nama',
            'titik_nominal',
            'status_kepemilikan',
            'tipe_antena',
            'keterangan:ntext',
            'foto',
            'status_kerja',
            'proyek',
        ],
    ]) ?>
    
    <p>
        <a href="<?php echo Yii::$app->params['url']?>site/update?id=<?php echo $model->id ?>" class='btn btn-primary'> Edit </a>&nbsp;
		<a href="<?php echo Yii::$app->params['url']?>site/delete?id=<?php echo $model->id ?>" class='btn btn-danger' onClick="return confirm('Are you sure want to delete this site?')">Delete </a>&nbsp;
    </p>

</div>
