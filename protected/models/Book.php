<?php
/**
 * This is the model class for table "book".
 *
 * The followings are the available columns in table 'book':
 * @property integer $id
 * @property string $name
 * @property integer $pages
 * @property string $published
 * @property integer $category_id
 * @property integer $publisher_id
 * @property string $img_path
 *
 * The followings are the available model relations:
 * @property Author[] $authors
 * @property Publisher $publisher
 * @property Category $category
 */
class Book extends CActiveRecord
{
    public static function getAllNames()
    {
        $rows=Book::model()->findAll();
        $tempArr=array();
        foreach ($rows as $r){
            $tempArr[$r->id]=$r->name;
        }
        return $tempArr;
    }


    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'book';
	}


    /**
     * @return string
     */
    public function getAuthorsNames()
    {
        $tempArr=array();
        if ($this->authors)
            foreach ( $this->authors as $author)
                $tempArr[]=$author->name;
        else
            return "None authors assigned";
        return implode(', ',$tempArr);
    }

    public function getAuthorsLinks()
    {
        $tempArr=array();
        if ($this->authors)
            foreach ( $this->authors as $author)
                $tempArr[]=CHtml::link(CHtml::encode($author->name), array('/author/view', 'id'=>$author->id));
        else
            return "None authors assigned";
        return implode(', ',$tempArr);
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, pages', 'required'),
			array('pages, category_id, publisher_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('img_path', 'file', 'types'=>'jpg, gif, png', 'safe' => true,'allowEmpty'=>true),
			array('published', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, pages, published, publisher_id, category_id, img_path', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'publisher' => array(self::BELONGS_TO, 'Publisher', 'publisher_id'),
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
			'authors' => array(self::MANY_MANY, 'Author', 'book_author(book_id, author_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'pages' => 'Pages',
			'published' => 'Published',
			'category_id' => 'Category',
            'publisher_id' => 'Publisher',
			'img_path' => 'Img',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
        $dateTemp='';
		if($this->published!=null)
		    $dateTemp=date('Y-m-d',strtotime($this->published));

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('pages',$this->pages,true);
//		$criteria->compare('published',$this->published,true);
		$criteria->compare('published',$dateTemp,true);

        $criteria->join='JOIN category AS cat ON category_id=cat.id JOIN publisher AS pub ON publisher_id=pub.id';
		$criteria->compare('cat.name', $this->category_id,true);
        $criteria->compare('pub.name',$this->publisher_id,true);
//        $criteria->compare('publisher_id',$this->publisher_id);
//        $criteria->compare('category_id',$this->category_id);


//        $criteria->compare('img_path',$this->img_path,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Book the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function showImgFromDatabase()
    {

        if($this->img_path!=''&&file_exists('images/' . $this->img_path)){

            return CHtml::image(Yii::app()->baseUrl . '/images/' .$this->img_path,$this->name,array('width'=>'100px','height'=>'100px','title'=>$this->name));

        }else{
            $url=Yii::app()->baseUrl."/images/noimage.png";
            return CHtml::image($url,'No Image',array('width'=>'100px','height'=>'100px','title'=>'No image'));
        }
    }
}
