<?php

/**
 * SearchForm class.
 * search form data. It is used by the 'search' action of 'ExperimentsController'.
 */
class SearchForm extends CFormModel
{
	public $search_txt;
	
	public function getDbConnection()
	{
		return Yii::app()->db2;
	}
	/**
	 * search query.
		$text is the search string
	 * return experiment_id
	 */
	public function search($text)
	{
	    $text1 = explode(" ",$text);
		$sql = null;
		$text = array_filter($text1);
		foreach($text as $val){
			$sql .= $val.' | ';
		}
		$cond1 = substr($sql,0,-3);
	    $userid =  Yii::app()->user->id;
	    $user = Yii::app()->db2->createCommand()
		->selectDistinct('e.experiment_id')
		->from('experiments e')
		->leftJoin('variables v', 'e.experiment_id = v.experiment__id')
		->leftJoin('constants c', 'e.experiment_id = c.experiment__id')
		->leftJoin('metrics m', 'e.experiment_id = m.experiment__id')
		->leftJoin('trials t', 'e.experiment_id = t.experiment__id')
		->leftJoin('documents d', 'e.experiment_id = d.experiment__id')
		->leftJoin('access_grants a', 'e.experiment_id = a.experiment__id')
		->where("(e.user__id = " . Yii::app()->user->id . " OR a.user__id = " . Yii::app()->user->id.") AND ((
		e.ts_en @@ to_tsquery('{$cond1}')) OR (v.ts_en @@ to_tsquery('{$cond1}'))  OR (c.ts_en @@ to_tsquery('{$cond1}'))  OR (m.ts_en @@ to_tsquery('{$cond1}'))  OR (t.ts_en @@ to_tsquery('{$cond1}'))  OR (d.ts_en @@ to_tsquery('{$cond1}')))")->queryAll();		
		// to print result use ->queryAll()
		// to print query use ->text;
		return $user;	

	}
}
