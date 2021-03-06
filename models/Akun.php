<?php

namespace app\models;

use Yii;
use app\models\Aktivitas;

/**
 * This is the model class for table "akun".
 *
 * @property string $nik
 * @property string $nama
 * @property string $gender
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $alamat
 * @property integer $jabatan
 * @property string $no_telp
 *
 * @property Aktivitas[] $aktivitas
 * @property Jabatan $jabatan0
 * @property Issue[] $issues
 * @property Pengumuman[] $pengumumen
 * @property Projectteam[] $projectteams
 */
class Akun extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $repeatPassword;
	// public $oldPassword;
	// public $newPassword; 
     
    public static function tableName()
    {
        return 'akun';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        	
        return [
            [['nik', 'username', 'password', 'repeatPassword', 'jabatan'], 'required'],
            [['nik', 'username'], 'unique', 'message' => '{attribute}: {value} already exists!'],
            [['jabatan'], 'string'],
            [['nik'], 'string', 'max' => 12],
            [['nama', 'username', 'no_telp'], 'string', 'max' => 30],
            [['gender'], 'string', 'max' => 14],
            [['email'], 'string', 'max' => 50,],
            [['alamat'], 'string', 'max' => 200],
            [['email'], 'email'],
            // [['oldPassword', 'newPassword', 'repeatPassword'], 'required', 'on' => 'changePassword'],
            [['password'], 'string', 'max' => 255, 'min' => 8],
            // [['oldPassword'], 'findPassword', 'on' => 'changePassword'],
            [['repeatPassword'], 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match!"],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nik' => 'Employee ID',
            'nama' => 'Full Name',
            'gender' => 'Gender',
            'email' => 'Email',
            'username' => 'Username',
            // 'oldPassword' => 'Old Password',
            'password' => 'Password',
            // 'newPassword' => 'New Password',
            'repeatPassword' => 'Confirm Password',
            'alamat' => 'Address',
            'jabatan' => 'Role',
            'no_telp' => 'Phone Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAktivitas()
    {
        return $this->hasMany(Aktivitas::className(), ['creator' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJabatan0()
    {
        return $this->hasOne(Jabatan::className(), ['id' => 'jabatan']);
    }

	/**public function getJabatan($idJabatan){
		$result = Yii::$app->db->createCommand("select jabatan from jabatan where id=$idJabatan")->queryOne();
		return $result['jabatan'];
	}*/

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssues()
    {
        return $this->hasMany(Issue::className(), ['creator' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPengumumen()
    {
        return $this->hasMany(Pengumuman::className(), ['creator' => 'nik']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectteams()
    {
        return $this->hasMany(Projectteam::className(), ['nik' => 'nik']);
    }
	
	public function beforeSave($insert)
	{
		$return = parent::beforeSave($insert);
		$this->password = md5($this->password);		
		return $return;
	}
	
	public function getAktivitaswork($id){
		$return =Aktivitas::find()->where(['creator'=>$id])->all();
		return $return;
	}
	
	public function getAktivitasdone($id){
		$return = Aktivitas::findAll(['creator'=>$id,'status'=>'done']);
		return $return;
	}
	
	public function getAktivitassukses($id){
		$aktivitas=Aktivitas::find()->where(['creator'=>$id,'status'=>'done'])->all();
		$i=0;
		foreach($aktivitas as $row){
			$deadline=$row->getDeadlinedate($row->type);
			if((strtotime($row['tanggal'])-strtotime($deadline))<0){
				$i=$i+1;
			}
		}
		return $i;
	}
	
	// public function findPassword($attribute, $params)
    // {
        // if (Yii::$app->user->identity->password != ($this->oldPassword))
            // return Yii::$app->user->identity->password;
    // }
}
