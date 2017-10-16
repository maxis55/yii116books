<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property integer $id
 * @property string $name
 * @property integer $parent
 *
 * The followings are the available model relations:
 * @property Category $parent0
 * @property Book[] $books
 * @property Category[] $categories
 */
class Category extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('name', 'required'),
			array('parent', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, parent', 'safe', 'on'=>'search'),
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
            'books' => array(self::HAS_MANY, 'Book', 'category_id'),
			'parent0' => array(self::BELONGS_TO, 'Category', 'parent'),
			'categories' => array(self::HAS_MANY, 'Category', 'parent'),
		);
	}

    public static function getAllCategories()
    {
        $rows=Category::model()->findAll();
        $tempArr=array();
        foreach($rows as $r)
        {
            $tempArr[$r->id]=$r->name;
        }
        return $tempArr;
    }

    public static function getAllCategoriesTreeView()
    {

        $criteria=new CDbCriteria;
        $criteria->addCondition('parent IS NULL');
        $rows=Category::model()->findAll($criteria);
        $tempArr=array();
        foreach($rows as $r)
        {
            $tempArr[$r->id]=$r->name;
            if ($r->categories)
            $r->getCategoryTreeWPrefix('-',$tempArr);
        }
        return $tempArr;
    }

    public function getParentCategoriesLine()
    {

        $ret=array($this->name);
        $p=$this;
        while (($p=$p->parent0)!=null){
            $ret[]=$p->getName();
        }
        return implode('->', array_reverse($ret));
    }

	public static function getAllCategoryTree(){
	    $tempArr=array();
        $criteria=new CDbCriteria;
        $criteria->addCondition('parent IS NULL');
        $rows=Category::model()->findAll($criteria);
        foreach ($rows as $row){
            $tempArr[]=$row->getCategoryTree();
        }

        return $tempArr;
    }


    public function getCategoryTree()
    {
        $subitems = array();
        if($this->categories)
            foreach($this->categories as $child)
            {
                $subitems[] = $child->getCategoryTree();
            }
        $temparray = array('text' => $this->name);
        if($subitems != array())
            $temparray = array_merge($temparray, array('children' => $subitems));
        return $temparray;
    }

    public function getCategoryTreeWPrefix($prefix='-',&$tempArr=null)
    {
        $prefix.=$prefix;

        foreach($this->categories as $subc)
        {
            $tempArr[$subc->getId()] = $prefix.$subc->getName();
            if($subc->categories)
                $subc->getCategoryTreeWPrefix($prefix,$tempArr);
        }
        return true;
    }
    /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'parent' => 'Parent',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('parent',$this->parent);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
