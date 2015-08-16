<?php

/**
 * Created by SUR-SER.
 * User: SURO
 * Date: 16.08.2015
 * Time: 15:22
 * Интерфейс доступа к web-сервису автомобильных запчастей barmaparts.com
 */
class BarmapartsService
{
    /**
     * Емейл от акк
     * @var string
     */
    private $_email = '<YOUR EMAIL>';

    /**
     * Пароль к акк
     * @var string
     */
    private $_password = '<YOUR PASS>';

    /**
     * Урл сервиса
     * @var string
     */
    private $_url = 'http://barmaparts.com/api/trade?wsdl';

    /**
     * Клиент
     * @var SoapClient
     */
    private $_client;

    /**
     * @param string|null $email - Емейл от акк
     * @param string|null $pass - Пароль к акк
     * @param string|null $url - Урл сервиса
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
     * Осуществляет поиск детали по указанному номеру, если находит деталь
     * то возвращает массив объектов, если не находит то возвращяет строку
     * При любом отрицательном результате возвращает строку
     * @param string $detailNumber Номер искомой детали
     * @param bool|false $findSubstitutes Запрос с заменами или без
     * (допустимы замены детали на другие детали данного или других изготовителей)
     * @return array|string возвращает массив объектов при положительном результате
     * и строку при любом отрицательном например: деталь не найденна или любая ошибка
     * объекты возвращаемые методом имеют следующую структуру:
     *
     *  public 'priceId' - Внутренний идентификатор прайса
     *  public 'detailNum' - Номер детали
     *  public 'makerName' - Имя производителя
     *  public 'detailName' - Имя/Описание детали
     *  public 'quantity' - Доступное количество
     *  public 'minimum' - Минимальное количество для заказа
     *  public 'region' - Регион
     *  public 'delivery' - Срок доставки
     *  public 'percentSupped' - Вероятность наличия запчастей с этого прайса в процентах
     *  public 'price' - Цена в долларах США
     */
    public function findDetail($detailNumber, $findSubstitutes = false){
        try{
            return $this->_client->FindDetail(['email' => $this->_email, 'password' => $this->_password],['article' => $detailNumber, 'findSubstitutes' => (bool)$findSubstitutes])->partList;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Осуществляет поиск детали по указанному номеру, если находит деталь
     * то возвращает массив объектов, если не находит то возвращяет строку
     * При любом отрицательном результате возвращает строку
     * По сути метод является идентичным методу findDetail, разница в том,
     * что в данном ответе кроме прочих параметров возвращается и вес детали
     * @param string $detailNumber Номер искомой детали
     * @param bool|false $findSubstitutes Запрос с заменами или без
     * (допустимы замены детали на другие детали данного или других изготовителей)
     * @return array|string возвращает массив объектов при положительном результате
     * и строку при любом отрицательном например: деталь не найденна или любая ошибка
     * объекты возвращаемые методом имеют следующую структуру:
     *
     *  public 'priceId' - Внутренний идентификатор прайса
     *  public 'detailNum' - Номер детали
     *  public 'makerName' - Имя производителя
     *  public 'detailName' - Имя/Описание детали
     *  public 'weight' - Вес
     *  public 'quantity' - Доступное количество
     *  public 'minimum' - Минимальное количество для заказа
     *  public 'region' - Регион
     *  public 'delivery' - Срок доставки
     *  public 'percentSupped' - Вероятность наличия запчастей с этого прайса в процентах
     *  public 'price' - Цена в долларах США
     */
    public function getPriceList($detailNumber, $findSubstitutes = false){
        try{
            return $this->_client->getPriceList(['email' => $this->_email, 'password' => $this->_password],['article' => $detailNumber, 'findSubstitutes' => (bool)$findSubstitutes])->arrayPrice;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Осуществляет поиск предложений по указанной детали.
     * Метод возвращает массив объектов Catalog, которые предоставляют информацию о детали по каталогам
     * @param string $detailNumber Номер искомой детали
     * @param bool|false $findSubstitutes Запрос с заменами или без
     * (допустимы замены детали на другие детали данного или других изготовителей)
     * @return array|string возвращает массив объектов при положительном результате
     * и строку при любом отрицательном например: деталь не найденна или любая ошибка
     * объекты возвращаемые методом имеют следующую структуру:
     *
     *  public 'catalogId' - Внутренний идентификатор каталога
     *  public 'catalogName' - Имя каталога
     *  public 'partNumber' - Номер детали
     *  public 'description' - Описание детали
     *  public 'originalMinPrice' - Минимальная цена запрашиваемого номера детали в долларах США
     *  public 'analogMinPrice' - Минимальная цена оригинальных заменов и аналогов в долларах США
     *  public 'priceListOriginal' - Массив объектов Price, которые предоставляют информацию о запрашиваемом номере детали
     *  public 'priceListAnalog' - Массив объектов Price, которые предоставляют информацию об оригинальных замен и аналогов детали
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