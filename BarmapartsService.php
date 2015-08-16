<?php

/**
 * Created by SUR-SER.
 * User: SURO
 * Date: 16.08.2015
 * Time: 15:22
 * ��������� ������� � web-������� ������������� ��������� barmaparts.com
 */
class BarmapartsService
{
    /**
     * ����� �� ���
     * @var string
     */
    private $_email = 'pdavit@rambler.ru';

    /**
     * ������ � ���
     * @var string
     */
    private $_password = 'miqvig';

    /**
     * ��� �������
     * @var string
     */
    private $_url = 'http://barmaparts.com/api/trade?wsdl';

    /**
     * ������
     * @var SoapClient
     */
    private $_client;

    /**
     * @param string|null $email - ����� �� ���
     * @param string|null $pass - ������ � ���
     * @param string|null $url - ��� �������
     */
    public function __construct($email = null,$pass = null, $url = null){
        if( ! empty($email)){
            $this->_email = $email;
        }

        if( ! empty($pass)){
            $this->_password = $pass;
        }

        if( ! empty($url)){
            $this->_url = $url;
        }

        $this->_client = new SoapClient($this->_url);
    }

    /**
     * ������������ ����� ������ �� ���������� ������, ���� ������� ������
     * �� ���������� ������ ��������, ���� �� ������� �� ���������� ������
     * ��� ����� ������������� ���������� ���������� ������
     * @param string $detailNumber ����� ������� ������
     * @param bool|false $findSubstitutes ������ � �������� ��� ���
     * (��������� ������ ������ �� ������ ������ ������� ��� ������ �������������)
     * @return array|string ���������� ������ �������� ��� ������������� ����������
     * � ������ ��� ����� ������������� ��������: ������ �� �������� ��� ����� ������
     * ������� ������������ ������� ����� ��������� ���������:
     *
     *  public 'priceId' - ���������� ������������� ������
     *  public 'detailNum' - ����� ������
     *  public 'makerName' - ��� �������������
     *  public 'detailName' - ���/�������� ������
     *  public 'quantity' - ��������� ����������
     *  public 'minimum' - ����������� ���������� ��� ������
     *  public 'region' - ������
     *  public 'delivery' - ���� ��������
     *  public 'percentSupped' - ����������� ������� ��������� � ����� ������ � ���������
     *  public 'price' - ���� � �������� ���
     */
    public function findDetail($detailNumber, $findSubstitutes = false){
        try{
            return $this->_client->FindDetail(['email' => $this->_email, 'password' => $this->_password],['article' => $detailNumber, 'findSubstitutes' => (bool)$findSubstitutes])->partList;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * ������������ ����� ������ �� ���������� ������, ���� ������� ������
     * �� ���������� ������ ��������, ���� �� ������� �� ���������� ������
     * ��� ����� ������������� ���������� ���������� ������
     * �� ���� ����� �������� ���������� ������ findDetail, ������� � ���,
     * ��� � ������ ������ ����� ������ ���������� ������������ � ��� ������
     * @param string $detailNumber ����� ������� ������
     * @param bool|false $findSubstitutes ������ � �������� ��� ���
     * (��������� ������ ������ �� ������ ������ ������� ��� ������ �������������)
     * @return array|string ���������� ������ �������� ��� ������������� ����������
     * � ������ ��� ����� ������������� ��������: ������ �� �������� ��� ����� ������
     * ������� ������������ ������� ����� ��������� ���������:
     *
     *  public 'priceId' - ���������� ������������� ������
     *  public 'detailNum' - ����� ������
     *  public 'makerName' - ��� �������������
     *  public 'detailName' - ���/�������� ������
     *  public 'weight' - ���
     *  public 'quantity' - ��������� ����������
     *  public 'minimum' - ����������� ���������� ��� ������
     *  public 'region' - ������
     *  public 'delivery' - ���� ��������
     *  public 'percentSupped' - ����������� ������� ��������� � ����� ������ � ���������
     *  public 'price' - ���� � �������� ���
     */
    public function getPriceList($detailNumber, $findSubstitutes = false){
        try{
            return $this->_client->getPriceList(['email' => $this->_email, 'password' => $this->_password],['article' => $detailNumber, 'findSubstitutes' => (bool)$findSubstitutes])->arrayPrice;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * ������������ ����� ����������� �� ��������� ������.
     * ����� ���������� ������ �������� Catalog, ������� ������������� ���������� � ������ �� ���������
     * @param string $detailNumber ����� ������� ������
     * @param bool|false $findSubstitutes ������ � �������� ��� ���
     * (��������� ������ ������ �� ������ ������ ������� ��� ������ �������������)
     * @return array|string ���������� ������ �������� ��� ������������� ����������
     * � ������ ��� ����� ������������� ��������: ������ �� �������� ��� ����� ������
     * ������� ������������ ������� ����� ��������� ���������:
     *
     *  public 'catalogId' - ���������� ������������� ��������
     *  public 'catalogName' - ��� ��������
     *  public 'partNumber' - ����� ������
     *  public 'description' - �������� ������
     *  public 'originalMinPrice' - ����������� ���� �������������� ������ ������ � �������� ���
     *  public 'analogMinPrice' - ����������� ���� ������������ ������� � �������� � �������� ���
     *  public 'priceListOriginal' - ������ �������� Price, ������� ������������� ���������� � ������������� ������ ������
     *  public 'priceListAnalog' - ������ �������� Price, ������� ������������� ���������� �� ������������ ����� � �������� ������
     *
     */
    public function getCatalogList($detailNumber, $findSubstitutes = false){
        try{
            return $this->_client->getCatalogList(['email' => $this->_email, 'password' => $this->_password],['article' => $detailNumber, 'findSubstitutes' => (bool)$findSubstitutes])->arrayCatalog;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}