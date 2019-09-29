<?php

namespace app\controllers;

use app\models\Period;
use app\models\Templates;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAnaliz1__()
    {
        $god = Period::find()->asArray()->all();
        return $this->render('analiz1', compact ('god'));
    }
    public function actionGetdata()
    {
        if (Yii::$app->request->isAjax)
        {
            if (!empty($_POST['year']))
            {
                $year = $_POST['year'];
                $query = "SELECT *, inf.an, case when IFNULL(region.BuildYear, 9999) > $year then 'false' else 'true' end as isBuild, 
                    
                    case when indicator_data.value > 6.5 then 
       concat(case when IFNULL(region.BuildYear, 9999) > $year then \"\" else Concat(\"Перинатариальный центр построен в \",region.BuildYear,\" году . \") end,
			\"В \", region.RegionName , \" не зафиксировано превышение целевого показателя Программы . \" )
     else 
		 case when indicator_data.value > 5.8 then 
		   concat(case when IFNULL(region.BuildYear, 9999) > $year then \"\" else Concat(\"Перинатариальный центр построен в \",region.BuildYear,\" году . \n\") end,
				\"В \", region.RegionName , \" зафиксировано отличие менее чем в 10 % от целевого показателя Программы . \" )
		 else 
		   concat(case when IFNULL(region.BuildYear, 9999) > $year then \"\" else Concat(\"Перинатариальный центр построен в \",region.BuildYear,\" году . \") end,
				\"В \", region.RegionName , \" \n зафиксировано соблюдение целевого показателя Программы . \" )
		 end     
     end as info

                                      FROM indicator_data INNER JOIN region ON region.id = indicator_data.RegionId
                                            left join (
select 
	cur.id, 
     case when (100 - (pre.value / cur.value) * 100) < 0 then
		concat(\"Падение по сравнению с предыдущим периодом на \", cast((100 - (pre.value / cur.value) * 100) as char(20)), \"%\")
     else case when (100 - (pre.value / cur.value) * 100) > 0 then
		concat(\"Рост по сравнению с предыдущим периодом на \", cast((100 - (pre.value / cur.value) * 100) as char(20)) , \"%\") 
        else \"Не изменился\" end
	end	as an
     
FROM analiz_db.indicator_data pre
	join analiz_db.indicator_data cur on pre.year = cur.year - 1 and pre.regionid = cur.regionid
    join analiz_db.region r on cur.regionid = r.id
                                            ) inf on inf.id = indicator_data.id
                                      
                                       
                                      WHERE YEAR = $year";

               //return debug($query);
                $connection = Yii::$app->getDb();
                $command = $connection->createCommand($query);

                $result = $command->queryAll();
                return json_encode($result);
            }

        }

    }

    public function actionGetdataByPeriod()
    {
        if (Yii::$app->request->isAjax)
        {
            $data = Period::find()->asArray()->all();
            return json_encode($data);
        }
    }


    public function actionAnaliz1()
    {
        $query = "select p.id as year, case when exists(SELECT id FROM analiz_db.indicator_data ind where ind.year = p.id) then 1 else 0 end as dataExists
from analiz_db.period p";
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand($query);

        $result = $command->queryAll();
        //$god = Period::find()->asArray()->all();
        return $this->render('analiz1', compact('result'));
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
