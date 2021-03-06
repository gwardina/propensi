<?php

namespace app\models;

use Yii;
use app\models\Kategori;

/**
 * This is the model class for table "barismilestone".
 *
 * @property integer $id
 * @property string $tanggal
 * @property integer $kategoriId
 * @property integer $siteId
 *
 * @property Kategori $kategori
 * @property Site $site
 */
class Barismilestone extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'barismilestone';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tanggal'], 'required'],
            [['tanggal'], 'safe'],
            [['kategoriId', 'siteId'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tanggal' => 'Date',
            'kategoriId' => 'Deadline Name',
            'siteId' => 'Site ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKategori()
    {
        return $this->hasOne(Kategori::className(), ['id' => 'kategoriId']);
    }

	public function getKategoriName($KategoriId){
		$result=Kategori::findOne(['id'=>$KategoriId]);
		//$result = Yii::$app->db->createCommand("select nama from kategori where id= '$KategoriId'") -> queryOne();
		return $result['nama'];
		//return nama dari kategori 
	}
	
	public function getKategoriNames($id){
		$result = Barismilestone::findOne(['id'=>$id]);
		$result2= Kategori::findOne(['id'=>$result['kategoriId']]);
		return $result2['nama'];
		//return nama dari kategori 
	}
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSite()
    {
        return $this->hasOne(Site::className(), ['id' => 'siteId']);
    }
}
