<?php
require_once(dirname(__FILE__).'/../lib/bootstrap.php');

class PensioPaymentTest extends MockitTestCase
{
	
	public function setup()
	{
		
	}
	
	public function testParsingOfSimpleXml()
	{
		$xml = new SimpleXMLElement('<Transaction><PaymentNatureService /><ReconciliationIdentifiers /></Transaction>');
		$payment = new PensioAPIPayment($xml);
	}

	public function testParsing_of_CountryOfOrigin()
	{
		$xml = new SimpleXMLElement('
            <Transaction>
                <TransactionId>14398495</TransactionId>
                <AuthType>paymentAndCapture</AuthType>
                <CardStatus>Valid</CardStatus>
                <CreditCardExpiry>
                    <Year>2015</Year>
                    <Month>11</Month>
                </CreditCardExpiry>
                <CreditCardToken>37ad3ff596164142876df477e13336e0aeef0905</CreditCardToken>
                <CreditCardMaskedPan>424374******7275</CreditCardMaskedPan>
                <ThreeDSecureResult>Disabled</ThreeDSecureResult>
                <CVVCheckResult>Matched</CVVCheckResult>
                <BlacklistToken>185c1c823a9b94731d9c6ba035d9b967587187bc</BlacklistToken>
                <ShopOrderId>ceae3968b82640e38a24ac162d8c2738</ShopOrderId>
                <Shop>Wargaming</Shop>
                <Terminal>Wargaming CC EUR</Terminal>
                <TransactionStatus>captured</TransactionStatus>
                <MerchantCurrency>978</MerchantCurrency>
                <CardHolderCurrency>978</CardHolderCurrency>
                <ReservedAmount>19.95</ReservedAmount>
                <CapturedAmount>19.95</CapturedAmount>
                <RefundedAmount>0.00</RefundedAmount>
                <RecurringDefaultAmount>0.00</RecurringDefaultAmount>
                <CreatedDate>2014-03-21 20:49:38</CreatedDate>
                <UpdatedDate>2014-03-21 20:49:41</UpdatedDate>
                <PaymentNature>CreditCard</PaymentNature>
                <PaymentSchemeName>Visa</PaymentSchemeName>
                <PaymentNatureService name="ValitorAcquirer">
                    <SupportsRefunds>true</SupportsRefunds>
                    <SupportsRelease>true</SupportsRelease>
                    <SupportsMultipleCaptures>true</SupportsMultipleCaptures>
                    <SupportsMultipleRefunds>true</SupportsMultipleRefunds>
                </PaymentNatureService>
                <ChargebackEvents/>
                <PaymentInfos>
                    <PaymentInfo name="item_name"><![CDATA[5 500 Gold]]></PaymentInfo>
                    <PaymentInfo name="original_amount"><![CDATA[19.95]]></PaymentInfo>
                    <PaymentInfo name="payment_method"><![CDATA[creditcard]]></PaymentInfo>
                    <PaymentInfo name="signature"><![CDATA[affe8e4f628ca55cbd07aa6b0b4fdffb]]></PaymentInfo>
                    <PaymentInfo name="wg_server"><![CDATA[eu]]></PaymentInfo>
                </PaymentInfos>
                <CustomerInfo>
                    <UserAgent>Mozilla/5.0 (Windows NT 6.1; WOW64; rv:27.0) Gecko/20100101 Firefox/27.0</UserAgent>
                    <IpAddress>91.152.252.214</IpAddress>
                    <Email><![CDATA[timo.k.honkanen@elisanet.fi]]></Email>
                    <Username/>
                    <CustomerPhone></CustomerPhone>
                    <OrganisationNumber></OrganisationNumber>
                    <CountryOfOrigin>
                        <Country>FI</Country>
                        <Source>CardNumber</Source>
                    </CountryOfOrigin>
                </CustomerInfo>
                <ReconciliationIdentifiers>
                    <ReconciliationIdentifier>
                        <Id>5c73f256-c096-43c5-8b07-e2b61c887e80</Id>
                        <Amount currency="978">19.95</Amount>
                        <Type>captured</Type>
                        <Date>2014-03-21T20:49:41+01:00</Date>
                    </ReconciliationIdentifier>
                </ReconciliationIdentifiers>
            </Transaction>');
		$payment = new PensioAPIPayment($xml);

		$this->assertEquals('FI', $payment->getCustomerInfo()->getCountryOfOrigin()->getCountry());
	}
}