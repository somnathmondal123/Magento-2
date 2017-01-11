<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Icepay\IcpCore\Model\Checkout;


/**
* The CheckoutExtended web method is almost identical to Checkout with the difference that it includes an
* extra XML field. This XML field must be populated with information about the order such as customer and
* product information. This means  that if an order contains multiple  products, and  this is not indicated
* somehow in the extended checkout request, that a partial refund or calculation of corrections or dis counts
* is not supported. Refunds or Cancellations of partial amounts is therefore not possible. This may also affect
* calculations of VAT if applicable.
 */
class CheckoutExtended
{

//TODO:

}
