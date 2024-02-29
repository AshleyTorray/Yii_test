<?php

namespace app\controllers;

use app\models\Box;
use app\models\BoxSearch;
use app\models\Product;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\data\ActiveDataProvider;

/**
 * BoxController implements the CRUD actions for Box model.
 */
class BoxController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Box models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BoxSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Box model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $matchFlag = Product::find()->where(['shippedQty' => $id])->where(['receivedQty' => $id]);
        $flag = false;
        if($matchFlag)
        {
            $flag = true;
        }
        return $this->render('view', [
            'matchFlag' => $flag,
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Box model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Box();
        $model->status = 2; // At Warehouse : 2
        $created_at = \Yii::$app->formatter->asDateTime('now', 'php:Y-m-d H:i:s');
        // $updated_at = $created_at;
        $model->created_at = $created_at;
        $model->updated_at = $created_at;
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Box model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    /**
     * Deletes an existing Box model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Box model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Box the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Box::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionCard($id)
    {
        $productModel = $this->findProductModel($id);
        $boxModel = $this->findModel($id);
        $productsProvider = new ActiveDataProvider([
            'query' => Product::find()->where(['box_id' => $id]),
        ]);
        $totalProducts = Product::find()->where(['box_id' => $id])->sum('shippedQty');
    
        return $this->render('card', [
            'totalProduct' => $totalProducts,
            'boxModel' => $boxModel,
            'model' => $productModel,
            'productsProvider' => $productsProvider,
        ]);
    }
    protected function findProductModel($id)
    {
        if (($productModel = Product::findOne(['box_id' => $id])) !== null) {
            return $productModel;
        }

        throw new NotFoundHttpException('The requested product does not exist.');
    }
    public function actionExport()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Box::find(), 
        ]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getProperties()
                    ->setCreator('Test client')
                    ->setTitle('Report Box');

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Date');
        $sheet->setCellValue('C1', 'Weight');
        $sheet->setCellValue('D1', 'Status');


        // ... Additional headers as needed

        $rows = $dataProvider->getModels();
        $rowIndex = 2;
        foreach ($rows as $row) {
            $sheet->setCellValue('A' . $rowIndex, $row->id);
            $sheet->setCellValue('B' . $rowIndex, $row->created_at);
            $sheet->setCellValue('c' . $rowIndex, $row->weight);
            $sheet->setCellValue('d' . $rowIndex, $row->status);
            $rowIndex++;
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="report.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        return Yii::$app->response->send();
    }


}
