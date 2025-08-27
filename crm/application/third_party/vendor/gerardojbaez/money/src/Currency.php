<?php

namespace Gerardojbaez\Money;

use Gerardojbaez\Money\Exceptions\CurrencyException;

class Currency
{
    /**
     * ISO-4217 Currency Code.
     *
     * @var string
     */
    protected $code;

    /**
     * Currency symbol.
     *
     * @var string
     */
    protected $symbol;

    /**
     * Currency precision (number of decimals).
     *
     * @var int
     */
    protected $precision;

    /**
     * Currency title.
     *
     * @var string
     */
    protected $title;

    /**
     * Currency thousand separator.
     *
     * @var string
     */
    protected $thousandSeparator;

    /**
     * Currency decimal separator.
     *
     * @var string
     */
    protected $decimalSeparator;

    /**
     * Currency symbol placement.
     *
     * @var string (front|after) currency
     */
    protected $symbolPlacement;

    /**
     * Currency Formats.
     *
     * Formats initially collected from
     * http://www.joelpeterson.com/blog/2011/03/formatting-over-100-currencies-in-php/
     *
     * All currencies were validated against some trusted
     * sources like Wikipedia, thefinancials.com and
     * cldr.unicode.org.
     *
     * Please note that each format used on each currency is
     * the format for that particular country/language.
     * When the country is unknown, the English format is used.
     *
     * @todo REFACTOR! This should be located on a separated file. Working on that!
     *
     * @var array
     */
    private static $currencies = [
        'AED' => [
            'code' => 'AED',
            'title' => 'UAE Dirham',
            'symbol' => 'AED',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'AFN' => [
            'code' => 'AFN',
            'title' => 'Afghani (؋)',
            'symbol' => '؋',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'ALL' => [
            'code' => 'ALL',
            'title' => 'Albanian lek',
            'symbol' => 'L',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'AMD' => [
            'code' => 'AMD',
            'title' => 'Armenian Dram',
            'symbol' => 'Դ',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'ANG' => [
            'code' => 'ANG',
            'title' => 'Netherlands Antillian Guilder',
            'symbol' => 'NAƒ ',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'AOA' => [
            'code' => 'AOA',
            'title' => 'Kwanza',
            'symbol' => 'Kz',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'ARS' => [
            'code' => 'ARS',
            'title' => 'Argentine Peso',
            'symbol' => 'AR$',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'AUD' => [
            'code' => 'AUD',
            'title' => 'Australian Dollar',
            'symbol' => 'AU$',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'AWG' => [
            'code' => 'AWG',
            'title' => 'Aruban Guilder',
            'symbol' => 'Afl. ',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'AZN' => [
            'code' => 'AZN',
            'title' => 'Azerbaijanian Manat',
            'symbol' => ' ₼ ',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'BAM' => [
            'code' => 'BAM',
            'title' => 'Bosnia and Herzegovina convertible mark',
            'symbol' => 'KM ',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'BBD' => [
            'code' => 'BBD',
            'title' => 'Barbados Dollar',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'BDT' => [
            'code' => 'BDT',
            'title' => 'Bangladesh, Taka',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'BGN' => [
            'code' => 'BGN',
            'title' => 'Bulgarian Lev',
            'symbol' => 'лв',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'after'
        ],
        'BHD' => [
            'code' => 'BHD',
            'title' => 'Bahraini Dinar',
            'symbol' => null,
            'precision' => 3,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'BIF' => [
            'code' => 'BIF',
            'title' => 'Burundi Franc',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'BMD' => [
            'code' => 'BMD',
            'title' => 'Bermudian Dollar',
            'symbol' => 'BD$',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'BND' => [
            'code' => 'BND',
            'title' => 'Brunei Dollar',
            'symbol' => 'B$',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'BOB' => [
            'code' => 'BOB',
            'title' => 'Bolivia, Boliviano',
            'symbol' => 'Bs',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'BOV' => [
            'code' => 'BOV',
            'title' => 'Mvdol',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'BRL' => [
            'code' => 'BRL',
            'title' => 'Brazilian Real',
            'symbol' => 'R$',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'BSD' => [
            'code' => 'BSD',
            'title' => 'Bahamian Dollar',
            'symbol' => 'B$',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'BTN' => [
            'code' => 'BTN',
            'title' => 'Ngultrum',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'BWP' => [
            'code' => 'BWP',
            'title' => 'Botswana, Pula',
            'symbol' => 'p',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'BYN' => [
            'code' => 'BYN',
            'title' => 'Belarussian Ruble',
            'symbol' => ' p. ',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'BYR' => [
            'code' => 'BYR',
            'title' => 'Belarussian Ruble',
            'symbol' => ' p. ',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'BZD' => [
            'code' => 'BZD',
            'title' => 'Belize Dollar',
            'symbol' => 'BZ$',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'CAD' => [
            'code' => 'CAD',
            'title' => 'Canadian Dollar',
            'symbol' => 'CA$',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'CDF' => [
            'code' => 'CDF',
            'title' => 'Congolese Franc',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'CHE' => [
            'code' => 'CHE',
            'title' => 'WIR Euro',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'CHF' => [
            'code' => 'CHF',
            'title' => 'Swiss Franc',
            'symbol' => 'SFr ',
            'precision' => 2,
            'thousandSeparator' => '\'',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'CHW' => [
            'code' => 'CHW',
            'title' => 'WIR Franc',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => '\'',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'CLF' => [
            'code' => 'CLF',
            'title' => 'Unidad de Fomento',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => '\'',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'CLP' => [
            'code' => 'CLP',
            'title' => 'Chilean Peso',
            'symbol' => 'CLP$',
            'precision' => 0,
            'thousandSeparator' => '.',
            'decimalSeparator' => '',
            'symbolPlacement' => 'before'
        ],
        'CNY' => [
            'code' => 'CNY',
            'title' => 'China Yuan Renminbi',
            'symbol' => 'CN¥',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'COP' => [
            'code' => 'COP',
            'title' => 'Colombian Peso',
            'symbol' => 'COL$',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'COU' => [
            'code' => 'COU',
            'title' => 'Unidad de Valor Real',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'CRC' => [
            'code' => 'CRC',
            'title' => 'Costa Rican Colon',
            'symbol' => '₡',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'CUC' => [
            'code' => 'CUC',
            'title' => 'Cuban Convertible Peso',
            'symbol' => 'CUC$',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'CUP' => [
            'code' => 'CUP',
            'title' => 'Cuban Peso',
            'symbol' => 'CUP$',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'CVE' => [
            'code' => 'CVE',
            'title' => 'Cabo Verde Escudo',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'CYP' => [
            'code' => 'CYP',
            'title' => 'Cyprus Pound',
            'symbol' => '£',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'CZK' => [
            'code' => 'CZK',
            'title' => 'Czech Koruna',
            'symbol' => ' Kč',
            'precision' => 2,
            'thousandSeparator' => ' ',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'after'
        ],
        'DJF' => [
            'code' => 'DJF',
            'title' => 'Djibouti Franc',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => ' ',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'after'
        ],
        'DKK' => [
            'code' => 'DKK',
            'title' => 'Danish Krone',
            'symbol' => ' kr.',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'after'
        ],
        'DOP' => [
            'code' => 'DOP',
            'title' => 'Dominican Peso',
            'symbol' => 'RD$',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'DZD' => [
            'code' => 'DZD',
            'title' => 'Algerian Dinar',
            'symbol' => ' .د.ج ',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'EEK' => [
            'code' => 'EEK',
            'title' => 'Estonian Kroon',
            'symbol' => ' kr ',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'EGP' => [
            'code' => 'EGP',
            'title' => 'Egyptian Pound',
            'symbol' => 'EGP',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'ERN' => [
            'code' => 'ERN',
            'title' => 'Nakfa',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'ETB' => [
            'code' => 'ETB',
            'title' => 'Ethiopian Birr',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'EUR' => [
            'code' => 'EUR',
            'title' => 'Euro',
            'symbol' => '€ ',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'FJD' => [
            'code' => 'FJD',
            'title' => 'Fiji Dollar',
            'symbol' => ' FJ$ ',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'FKP' => [
            'code' => 'FKP',
            'title' => 'Falkland Islands Pound',
            'symbol' => ' £ ',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'GBP' => [
            'code' => 'GBP',
            'title' => 'Pound Sterling',
            'symbol' => '£',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'GEL' => [
            'code' => 'GEL',
            'title' => 'Lari',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'GGP' => [
            'code' => 'GGP',
            'title' => 'Guernsey Pound',
            'symbol' => '£',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'GHC' => [
            'code' => 'GHC',
            'title' => 'Ghana, Cedi',
            'symbol' => 'GH₵',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'GHS' => [
            'code' => 'GHS',
            'title' => 'Ghan Cedi',
            'symbol' => 'GH₵',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'GIP' => [
            'code' => 'GIP',
            'title' => 'Gibraltar Pound',
            'symbol' => '£',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'GMD' => [
            'code' => 'GMD',
            'title' => 'Dalasi',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'GNF' => [
            'code' => 'GNF',
            'title' => 'Guine Franc',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'GTQ' => [
            'code' => 'GTQ',
            'title' => 'Guatemala, Quetzal',
            'symbol' => 'Q',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'GYD' => [
            'code' => 'GYD',
            'title' => 'Guyan Dollar',
            'symbol' => 'GY$',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'HKD' => [
            'code' => 'HKD',
            'title' => 'Hong Kong Dollar',
            'symbol' => 'HK$',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'HNL' => [
            'code' => 'HNL',
            'title' => 'Honduras, Lempira',
            'symbol' => 'L',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'HRK' => [
            'code' => 'HRK',
            'title' => 'Croatian Kuna',
            'symbol' => ' kn',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'after'
        ],
        'HTG' => [
            'code' => 'HTG',
            'title' => 'Gourde',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'after'
        ],
        'HUF' => [
            'code' => 'HUF',
            'title' => 'Hungary, Forint',
            'symbol' => ' Ft',
            'precision' => 0,
            'thousandSeparator' => ' ',
            'decimalSeparator' => '',
            'symbolPlacement' => 'after'
        ],
        'IDR' => [
            'code' => 'IDR',
            'title' => 'Indonesia, Rupiah',
            'symbol' => 'Rp',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'ILS' => [
            'code' => 'ILS',
            'title' => 'New Israeli Shekel ₪',
            'symbol' => ' ₪',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'after'
        ],
        'IMP' => [
            'code' => 'IMP',
            'title' => 'Manx Pound',
            'symbol' => '£',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'after'
        ],
        'INR' => [
            'code' => 'INR',
            'title' => 'Indian Rupee ₹',
            'symbol' => '₹',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'IQD' => [
            'code' => 'IQD',
            'title' => 'Iraqi Dinar',
            'symbol' => ' .د.ع ',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'IRR' => [
            'code' => 'IRR',
            'title' => 'Iranian Rial',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'ISK' => [
            'code' => 'ISK',
            'title' => 'Iceland Krona',
            'symbol' => ' kr',
            'precision' => 0,
            'thousandSeparator' => '.',
            'decimalSeparator' => '',
            'symbolPlacement' => 'after'
        ],
        'JEP' => [
            'code' => 'JEP',
            'title' => 'Jersey Pound',
            'symbol' => '£',
            'precision' => 0,
            'thousandSeparator' => '.',
            'decimalSeparator' => '',
            'symbolPlacement' => 'after'
        ],
        'JMD' => [
            'code' => 'JMD',
            'title' => 'Jamaican Dollar',
            'symbol' => 'J$',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'JOD' => [
            'code' => 'JOD',
            'title' => 'Jordanian Dinar',
            'symbol' => null,
            'precision' => 3,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'JPY' => [
            'code' => 'JPY',
            'title' => 'Japan, Yen',
            'symbol' => '¥',
            'precision' => 0,
            'thousandSeparator' => ',',
            'decimalSeparator' => '',
            'symbolPlacement' => 'before'
        ],
        'KES' => [
            'code' => 'KES',
            'title' => 'Kenyan Shilling',
            'symbol' => 'KSh',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'KGS' => [
            'code' => 'KGS',
            'title' => 'Som',
            'symbol' => 'сом',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'KHR' => [
            'code' => 'KHR',
            'title' => 'Riel',
            'symbol' => '៛',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'KMF' => [
            'code' => 'KMF',
            'title' => 'Comoro Franc',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'KPW' => [
            'code' => 'KPW',
            'title' => 'North Korean Won',
            'symbol' => '₩',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'KRW' => [
            'code' => 'KRW',
            'title' => 'South Korea, Won ₩',
            'symbol' => '₩',
            'precision' => 0,
            'thousandSeparator' => ',',
            'decimalSeparator' => '',
            'symbolPlacement' => 'before'
        ],
        'KWD' => [
            'code' => 'KWD',
            'title' => 'Kuwaiti Dinar',
            'symbol' => 'K.D.',
            'precision' => 3,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'KYD' => [
            'code' => 'KYD',
            'title' => 'Cayman Islands Dollar',
            'symbol' => 'CI$',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'KZT' => [
            'code' => 'KZT',
            'title' => 'Tenge',
            'symbol' => '₸',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'LAK' => [
            'code' => 'LAK',
            'title' => 'Kip',
            'symbol' => '₭',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'LBP' => [
            'code' => 'LBP',
            'title' => 'Lebanese Pound',
            'symbol' => 'LBP',
            'precision' => 0,
            'thousandSeparator' => ',',
            'decimalSeparator' => '',
            'symbolPlacement' => 'before'
        ],
        'LKR' => [
            'code' => 'LKR',
            'title' => 'Sri Lank Rupee',
            'symbol' => '₨',
            'precision' => 0,
            'thousandSeparator' => ',',
            'decimalSeparator' => '',
            'symbolPlacement' => 'before'
        ],
        'LRD' => [
            'code' => 'LRD',
            'title' => 'Liberian Dollar',
            'symbol' => 'L$',
            'precision' => 0,
            'thousandSeparator' => ',',
            'decimalSeparator' => '',
            'symbolPlacement' => 'before'
        ],
        'LSL' => [
            'code' => 'LSL',
            'title' => 'Loti',
            'symbol' => null,
            'precision' => 0,
            'thousandSeparator' => ',',
            'decimalSeparator' => '',
            'symbolPlacement' => 'before'
        ],
        'LTL' => [
            'code' => 'LTL',
            'title' => 'Lithuanian Litas',
            'symbol' => ' Lt',
            'precision' => 2,
            'thousandSeparator' => ' ',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'after'
        ],
        'LVL' => [
            'code' => 'LVL',
            'title' => 'Latvian Lats',
            'symbol' => 'Ls',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'LYD' => [
            'code' => 'LYD',
            'title' => 'Libyan Dinar',
            'symbol' => ' .د.ل ',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'MAD' => [
            'code' => 'MAD',
            'title' => 'Moroccan Dirham',
            'symbol' => ' .د.م ',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'MDL' => [
            'code' => 'MDL',
            'title' => 'Moldovan Leu',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'MGA' => [
            'code' => 'MGA',
            'title' => 'Malagasy riary',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'MKD' => [
            'code' => 'MKD',
            'title' => 'Macedonia, Denar',
            'symbol' => 'ден ',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'MMK' => [
            'code' => 'MMK',
            'title' => 'Kyat',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'MNT' => [
            'code' => 'MNT',
            'title' => 'Tugrik',
            'symbol' => '₮',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'MOP' => [
            'code' => 'MOP',
            'title' => 'Pataca',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'MRO' => [
            'code' => 'MRO',
            'title' => 'Ouguiya',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'MTL' => [
            'code' => 'MTL',
            'title' => 'Maltese Lira',
            'symbol' => 'Lm',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'MUR' => [
            'code' => 'MUR',
            'title' => 'Mauritius Rupee',
            'symbol' => 'Rs',
            'precision' => 0,
            'thousandSeparator' => ',',
            'decimalSeparator' => '',
            'symbolPlacement' => 'before'
        ],
        'MVR' => [
            'code' => 'MVR',
            'title' => 'Rufiyaa',
            'symbol' => null,
            'precision' => 0,
            'thousandSeparator' => ',',
            'decimalSeparator' => '',
            'symbolPlacement' => 'before'
        ],
        'MWK' => [
            'code' => 'MWK',
            'title' => 'Kwacha',
            'symbol' => null,
            'precision' => 0,
            'thousandSeparator' => ',',
            'decimalSeparator' => '',
            'symbolPlacement' => 'before'
        ],
        'MXN' => [
            'code' => 'MXN',
            'title' => 'Mexican Peso',
            'symbol' => 'MX$',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'MXV' => [
            'code' => 'MXV',
            'title' => 'Mexican Unidad de Inversion (UDI)',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'MYR' => [
            'code' => 'MYR',
            'title' => 'Malaysian Ringgit',
            'symbol' => 'RM',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'MZM' => [
            'code' => 'MZM',
            'title' => 'Mozambique Metical',
            'symbol' => 'MT',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'MZN' => [
            'code' => 'MZN',
            'title' => 'Mozambique Metical',
            'symbol' => 'MT',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'NAD' => [
            'code' => 'NAD',
            'title' => 'Namibi Dollar',
            'symbol' => 'N$',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'NGN' => [
            'code' => 'NGN',
            'title' => 'Naira',
            'symbol' => '₦',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'NIO' => [
            'code' => 'NIO',
            'title' => 'Cordob Oro',
            'symbol' => 'C$',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'NOK' => [
            'code' => 'NOK',
            'title' => 'Norwegian Krone',
            'symbol' => 'kr ',
            'precision' => 2,
            'thousandSeparator' => ' ',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'NPR' => [
            'code' => 'NPR',
            'title' => 'Nepalese Rupee',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'NZD' => [
            'code' => 'NZD',
            'title' => 'New Zealand Dollar',
            'symbol' => 'NZ$',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'OMR' => [
            'code' => 'OMR',
            'title' => 'Rial Omani',
            'symbol' => 'OMR',
            'precision' => 3,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'PAB' => [
            'code' => 'PAB',
            'title' => 'Balboa',
            'symbol' => 'B/.',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'PEN' => [
            'code' => 'PEN',
            'title' => 'Peru, Nuevo Sol',
            'symbol' => 'S/.',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'PGK' => [
            'code' => 'PGK',
            'title' => 'Kina',
            'symbol' => 'null',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'PHP' => [
            'code' => 'PHP',
            'title' => 'Philippine Peso',
            'symbol' => '₱',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'PKR' => [
            'code' => 'PKR',
            'title' => 'Pakistan Rupee',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'PLN' => [
            'code' => 'PLN',
            'title' => 'Poland, Zloty',
            'symbol' => ' zł',
            'precision' => 2,
            'thousandSeparator' => ' ',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'after'
        ],
        'PYG' => [
            'code' => 'PYG',
            'title' => 'Paraguayan guaraní',
            'symbol' => '₲',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'after'
        ],
        'QAR' => [
            'code' => 'QAR',
            'title' => 'Qatari Riyal',
            'symbol' => 'ر.ق',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'after'
        ],
        'ROL' => [
            'code' => 'ROL',
            'title' => 'Romania, Old Leu',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'RON' => [
            'code' => 'RON',
            'title' => 'Romania, New Leu',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'RSD' => [
            'code' => 'RSD',
            'title' => 'Serbian dinar',
            'symbol' => 'din',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'after'
        ],
        'RUB' => [
            'code' => 'RUB',
            'title' => 'Russian Ruble',
            'symbol' => ' руб',
            'precision' => 2,
            'thousandSeparator' => ' ',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'after'
        ],
        'RUR' => [
            'code' => 'RUR',
            'title' => 'Russian ruble',
            'symbol' => '₽',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'after'
        ],
        'RWF' => [
            'code' => 'RWF',
            'title' => 'Rwandan franc',
            'symbol' => 'R₣',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'after'
        ],
        'SAR' => [
            'code' => 'SAR',
            'title' => 'Saudi Riyal',
            'symbol' => 'SAR',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'SBD' => [
            'code' => 'SBD',
            'title' => 'Solomon Islands dollar',
            'symbol' => 'Si$',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'after'
        ],
        'SCR' => [
            'code' => 'SCR',
            'title' => 'Seychelles Rupee',
            'symbol' => 'SR',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'after'
        ],
        'SDG' => [
            'code' => 'SDG',
            'title' => 'Sudanese Pound',
            'symbol' => 'SR',
            'precision' => 3,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'after'
        ],
        'SEK' => [
            'code' => 'SEK',
            'title' => 'Swedish Krona',
            'symbol' => ' kr',
            'precision' => 2,
            'thousandSeparator' => ' ',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'after'
        ],
        'SGD' => [
            'code' => 'SGD',
            'title' => 'Singapore Dollar',
            'symbol' => 'S$',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'SHP' => [
            'code' => 'SHP',
            'title' => ' Saint Helen Pound',
            'symbol' => '£',
            'precision' => 3,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'SIT' => [
            'code' => 'SIT',
            'title' => 'Slovenia, Tolar',
            'symbol' => null,
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'SKK' => [
            'code' => 'SKK',
            'title' => 'Slovak Koruna',
            'symbol' => ' SKK',
            'precision' => 2,
            'thousandSeparator' => ' ',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'after'
        ],
        'SLL' => [
            'code' => 'SLL',
            'title' => ' Sierra Leonean leone',
            'symbol' => 'Le',
            'precision' => 3,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'SOS' => [
            'code' => 'SOS',
            'title' => ' Somali Shilling (S)',
            'symbol' => 'Sh.so.',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'SRD' => [
            'code' => 'SRD',
            'title' => ' Surinam Dollar',
            'symbol' => '$',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'SSP' => [
            'code' => 'SSP',
            'title' => ' South Sudanese Pound',
            'symbol' => '£',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'STD' => [
            'code' => 'STD',
            'title' => 'dobra',
            'symbol' => 'Db',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'SVC' => [
            'code' => 'SVC',
            'title' => 'El Salvador Colon',
            'symbol' => '₡',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'SYP' => [
            'code' => 'SYP',
            'title' => 'Syrian Pound (.ل.س)',
            'symbol' => '£S',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'SZL' => [
            'code' => 'SZL',
            'title' => 'Swaziland, Lilangeni',
            'symbol' => 'E',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'THB' => [
            'code' => 'THB',
            'title' => 'Thailand, Baht ฿',
            'symbol' => '฿',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'TJS' => [
            'code' => 'TJS',
            'title' => 'somoni',
            'symbol' => 'ЅM',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'TMT' => [
            'code' => 'TMT',
            'title' => 'Turkmenistan New Manat',
            'symbol' => 'T',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'TND' => [
            'code' => 'TND',
            'title' => 'Tunisian Dinar (.د.ت)',
            'symbol' => 'DT',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'TOP' => [
            'code' => 'TOP',
            'title' => 'Tonga, Paanga',
            'symbol' => 'T$ ',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'TRL' => [
            'code' => 'TRL',
            'title' => 'Turkish Lira',
            'symbol' => '₺',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'after'
        ],
        'TRY' => [
            'code' => 'TRY',
            'title' => 'New Turkish Lira',
            'symbol' => '₺',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'TTD' => [
            'code' => 'TTD',
            'title' => 'Trinidad and Tobago Dollar ',
            'symbol' => 'TT$',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'after'
        ],
        'TWD' => [
            'code' => 'TWD',
            'title' => 'New Taiwan Dollar  ',
            'symbol' => 'NT$',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'after'
        ],
        'TZS' => [
            'code' => 'TZS',
            'title' => 'Tanzanian Shilling',
            'symbol' => 'TSh',
            'precision' => 0,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'UAH' => [
            'code' => 'UAH',
            'title' => 'Ukraine, Hryvnia',
            'symbol' => ' ₴',
            'precision' => 2,
            'thousandSeparator' => ' ',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'after'
        ],
        'UGX' => [
            'code' => 'UGX',
            'title' => 'Ugand Shilling (USh)',
            'symbol' => 'USh',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'after'
        ],
        'USD' => [
            'code' => 'USD',
            'title' => 'US Dollar',
            'symbol' => '$',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'USN' => [
            'code' => 'USN',
            'title' => ' US Dollar (Next day)',
            'symbol' => 'US$',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'after'
        ],
        'UYI' => [
            'code' => 'UYI',
            'title' => ' Uruguay Peso en Unidades Indexadas',
            'symbol' => '$US',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'UYU' => [
            'code' => 'UYU',
            'title' => 'Peso Uruguayo',
            'symbol' => '$U ',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'UZS' => [
            'code' => 'UZS',
            'title' => 'Uzbekistan Sum (so’m)',
            'symbol' => '(so’m) ',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'VEB' => [
            'code' => 'VEB',
            'title' => 'Venezuela, Bolivar',
            'symbol' => 'Bs.',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'VEF' => [
            'code' => 'VEF',
            'title' => 'Venezuela Bolivares Fuertes',
            'symbol' => 'Bs.',
            'precision' => 2,
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'symbolPlacement' => 'before'
        ],
        'VND' => [
            'code' => 'VND',
            'title' => 'Viet Nam, Dong ₫',
            'symbol' => ' ₫',
            'precision' => 0,
            'thousandSeparator' => '.',
            'decimalSeparator' => '',
            'symbolPlacement' => 'after'
        ],
        'VUV' => [
            'code' => 'VUV',
            'title' => 'Vanuatu, Vatu',
            'symbol' => 'VT',
            'precision' => 0,
            'thousandSeparator' => ',',
            'decimalSeparator' => '',
            'symbolPlacement' => 'before'
        ],
        'WST' => [
            'code' => 'WST',
            'title' => 'Tala',
            'symbol' => 'WS$ ',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'after'
        ],
        'XAF' => [
            'code' => 'XAF',
            'title' => 'CF Franc BEAC',
            'symbol' => 'FCFA',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'XCD' => [
            'code' => 'XCD',
            'title' => 'East Caribbean Dollar',
            'symbol' => 'EC$',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'XDR' => [
            'code' => 'XDR',
            'title' => 'SDR (Special Drawing Right)',
            'symbol' => 'XDR',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'XOF' => [
            'code' => 'XOF',
            'title' => 'CF Franc BCEAO',
            'symbol' => 'CFA',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'after'
        ],
        'XPF' => [
            'code' => 'XPF',
            'title' => 'CFP Franc',
            'symbol' => '₣',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'after'
        ],
        'XSU' => [
            'code' => 'XSU',
            'title' => 'Sucre',
            'symbol' => 'S/.',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'after'
        ],
        'XUA' => [
            'code' => 'XUA',
            'title' => 'ADB Unit of Account',
            'symbol' => 'XUA',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'after'
        ],
        'YER' => [
            'code' => 'YER',
            'title' => 'Yemeni Rial (.ر.ي)',
            'symbol' => '﷼',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'after'
        ],
        'ZAR' => [
            'code' => 'ZAR',
            'title' => 'South Africa, Rand',
            'symbol' => 'R',
            'precision' => 2,
            'thousandSeparator' => ' ',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'ZMW' => [
            'code' => 'ZMW',
            'title' => 'Zambian Kwacha',
            'symbol' => 'ZK',
            'precision' => 2,
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'after'
        ],
        'ZWD' => [
            'code' => 'ZWD',
            'title' => 'Zimbabwe Dollar',
            'symbol' => 'Z$',
            'precision' => 2,
            'thousandSeparator' => ' ',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
        'ZWL' => [
            'code' => 'ZWL',
            'title' => 'Zimbabwe Dollar',
            'symbol' => 'Z$',
            'precision' => 2,
            'thousandSeparator' => ' ',
            'decimalSeparator' => '.',
            'symbolPlacement' => 'before'
        ],
    ];


    /**
     * Create new Currency instance.
     *
     * @param string Currency ISO-4217 code
     * @return void
     */
    public function __construct($code)
    {
        if (! $this->hasCurrency($code)) {
            throw new CurrencyException("Currency not found: \"{$code}\"");
        }

        $currency = $this->getCurrency($code);

        foreach ($currency as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Get currency ISO-4217 code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get currency symbol.
     *
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * Get currency precision.
     *
     * @return int
     */
    public function getPrecision()
    {
        return $this->precision;
    }

    /**
     * @param integer $precision
     * @return $this
     */
    public function setPrecision($precision)
    {
        $this->precision = $precision;

        return $this;
    }

    /**
     * Get currency title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get currency thousand separator.
     *
     * @return string
     */
    public function getThousandSeparator()
    {
        return $this->thousandSeparator;
    }

    /**
     * @param string $separator
     * @return $this
     */
    public function setThousandSeparator($separator)
    {
        $this->thousandSeparator = $separator;

        return $this;
    }

    /**
     * Get currency decimal separator.
     *
     * @return string
     */
    public function getDecimalSeparator()
    {
        return $this->decimalSeparator;
    }

    /**
     * @param string $separator
     * @return $this
     */
    public function setDecimalSeparator($separator)
    {
        $this->decimalSeparator = $separator;

        return $this;
    }

    /**
     * Get currency symbol placement.
     *
     * @return string
     */
    public function getSymbolPlacement()
    {
        return $this->symbolPlacement;
    }

    /**
     * @param string $placement [before|after]
     * @return $this
     */
    public function setSymbolPlacement($placement)
    {
        $this->symbolPlacement = $placement;

        return $this;
    }

    /**
     * Get all currencies.
     *
     * @return array
     */
    public static function getAllCurrencies()
    {
        return self::$currencies;
    }

    /**
     * Get currency.
     *
     * @access protected
     * @return array
     */
    protected function getCurrency($code)
    {
        return self::$currencies[$code];
    }

    /**
     * Check currency existence (within the class)
     *
     * @access protected
     * @return bool
     */
    protected function hasCurrency($code)
    {
        return isset(self::$currencies[$code]);
    }
}
