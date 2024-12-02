<!--

<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
  <input type="hidden" name="cmd" value="_s-xclick" />
  <input type="hidden" name="hosted_button_id" value="GTNZVSWQQ7478" />
  <input type="hidden" name="currency_code" value="USD" />
  <input type="image" src="https://www.paypalobjects.com/es_XC/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" title="PayPal es una forma segura y fácil de pagar en línea." alt="Comprar ahora" />
</form>

-->

<x-app-layout>
@dump($responseDataFast)
<script src="https://test.oppwa.com/v1/paymentWidgets.js?checkoutId=<?php echo $responseDataFast['id'] ?> "></script>
<form action="{{ route('Datafast') }}" class="paymentWidgets" data-brands="VISA MASTER DINERS DISCOVER AMEX"> </form>

<script type="text/javascript" src="https://www.datafast.com.ec/js/dfAdditionalValidations1.js">
</x-app-layout>