# CÓDIGOS DE RESPUESTA
https://pagosonline.redsys.es/codigosRespuesta.html

En este apartado se presenta un glosario de los códigos de respuesta que se pueden recibir en el proceso de integración y realización de una operación:

## Códigos de error

El error que se ha producido se puede obtener consultando en el módulo de administración. En el caso de realizar una integración REST el código se error también se recibirá en la respuesta de la petición REST.

| Código de error | Error SIS0XXX | Descripción |
|-----:|----------|-|
| 8102 |          | Operación que ha sido redirigida al emisor a autenticar EMV3DS V1.0.2 (para H2H)
| 8210 |          | Operación que ha sido redirigida al emisor a autenticar EMV3DS V2.1.0 (para H2H)
| 8220 |          | Operación que ha sido redirigida al emisor a autenticar EMV3DS V2.2.0 (para H2H)
| 9001 | SIS0001  | Error Interno
| 9002 | SIS0002  | Error genérico
| 9003 | SIS0003  | Error genérico
| 9004 | SIS0004  | Error genérico
| 9005 | SIS0005  | Error genérico
| 9006 | SIS0006  | Error genérico
| 9007 | SIS0007  | El mensaje de petición no es correcto, debe revisar el formato
| 9008 | SIS0008  | falta Ds_Merchant_MerchantCode
| 9009 | SIS0009  | Error de formato en Ds_Merchant_MerchantCode
| 9010 | SIS0010  | Error falta Ds_Merchant_Terminal
| 9011 | SIS0011  | Error de formato en Ds_Merchant_Terminal
| 9012 | SIS0012  | Error genérico
| 9013 | SIS0013  | Error genérico
| 9014 | SIS0014  | Error de formato en Ds_Merchant_Order
| 9015 | SIS0015  | Error falta Ds_Merchant_Currency
| 9016 | SIS0016  | Error de formato en Ds_Merchant_Currency
| 9018 | SIS0018  | Falta Ds_Merchant_Amount
| 9019 | SIS0019  | Error de formato en Ds_Merchant_Amount
| 9020 | SIS0020  | Falta Ds_Merchant_MerchantSignature
| 9021 | SIS0021  | La Ds_Merchant_MerchantSignature viene vacía
| 9022 | SIS0022  | Error de formato en Ds_Merchant_TransactionType
| 9023 | SIS0023  | Ds_Merchant_TransactionType desconocido
| 9024 | SIS0024  | El Ds_Merchant_ConsumerLanguage tiene mas de 3 posiciones
| 9025 | SIS0025  | Error de formato en Ds_Merchant_ConsumerLanguage
| 9026 | SIS0026  | Problema con la configuración
| 9027 | SIS0027  | Revisar la moneda que está enviando
| 9028 | SIS0028  | Error Comercio / terminal está dado de baja
| 9029 | SIS0029  | Que revise como está montando el mensaje
| 9030 | SIS0030  | Nos llega un tipo de operación errónea
| 9031 | SIS0031  | Nos está llegando un método de pago erróneo
| 9032 | SIS0032  | Revisar como está montando el mensaje para la devolución.
| 9033 | SIS0033  | El tipo de operación es erróneo
| 9034 | SIS0034  | error interno
| 9035 | SIS0035  | Error interno al recuperar datos de sesión
| 9036 | SIS0036  | Error al tomar los datos para Pago Móvil desde el XML
| 9037 | SIS0037  | El número de teléfono no es válido
| 9038 | SIS0038  | Error genérico
| 9039 | SIS0039  | Error genérico
| 9040 | SIS0040  | El comercio tiene un error en la configuración, tienen que hablar con su entidad.
| 9041 | SIS0041  | Error en el cálculo de la firma
| 9042 | SIS0042  | Error en el cálculo de la firma
| 9043 | SIS0043  | Error genérico
| 9044 | SIS0044  | Error genérico
|      | SIS0045  | Error genérico
| 9046 | SIS0046  | Problema con la configuración del bin de la tarjeta
| 9047 | SIS0047  | Error genérico
| 9048 | SIS0048  | Error genérico
| 9049 | SIS0049  | Error genérico
| 9050 | SIS0050  | Error genérico
| 9051 | SIS0051  | Error número de pedido repetido
| 9052 | SIS0052  | Error genérico
| 9053 | SIS0053  | Error genérico
| 9054 | SIS0054  | No existe operación sobre la que realizar la devolución
| 9055 | SIS0055  | existe más de un pago con el mismo número de pedido
| 9056 | SIS0056  | Revisar el estado de la autorización
| 9057 | SIS0057  | Que revise el importe que quiere devolver( supera el permitido)
| 9058 | SIS0058  | Que revise los datos con los que está validando la confirmación
| 9059 | SIS0059  | Revisar que existe esa operación
| 9060 | SIS0060  | Revisar que exista la confirmación
| 9061 | SIS0061  | Revisar el estado de la preautorización
| 9062 | SIS0062  | Que el comercio revise el importe a confirmar.
| 9063 | SIS0063  | Que el comercio revise el númer de tarjeta que nos están enviando.
| 9064 | SIS0064  | Número de posiciones de la tarjeta incorrecto
| 9065 | SIS0065  | El número de tarjeta no es numérico
| 9066 | SIS0066  | Error mes de caducidad
| 9067 | SIS0067  | El mes de la caducidad no es numérico
| 9068 | SIS0068  | El mes de la caducidad no es válido
| 9069 | SIS0069  | Año de caducidad no valido
| 9070 | SIS0070  | El Año de la caducidad no es numérico
| 9071 | SIS0071  | Tarjeta caducada
| 9072 | SIS0072  | Operación no anulable
| 9073 | SIS0073  | Error en la anulación
| 9074 | SIS0074  | Falta Ds_Merchant_Order ( Pedido )
| 9075 | SIS0075  | El comercio tiene que revisar cómo está enviando el número de pedido
| 9077 | SIS0077  | El comercio tiene que revisar el número de pedido
| 9078 | SIS0078  | Por la configuración de los métodos de pago de su comercio no se permiten los pagos con esa tarjeta.
| 9079 | SIS0079  | Error genérico
| 9080 | SIS0080  | Error genérico
| 9081 | SIS0081  | Se ha perdico los datos de la sesión
| 9082 | SIS0082  | Error genérico
| 9083 | SIS0083  | Error genérico
| 9084 | SIS0084  | El valor de Ds_Merchant_Conciliation es nulo.
| 9085 | SIS0085  | El valor de Ds_Merchant_Conciliation no es numérico.
| 9086 | SIS0086  | El valor de Ds_Merchant_Conciliation no ocupa 6 posiciones.
| 9087 | SIS0087  | El valor de Ds_Merchant_Session es nulo.
| 9088 | SIS0088  | El comercio tiene que revisar el valor que envía en ese campo.
| 9089 | SIS0089  | El valor de caducidad no ocupa 4 posiciones.
| 9090 | SIS0090  | Error genérico. Consulte con Soporte.
| 9091 | SIS0091  | Error genérico. Consulte con Soporte.
| 9092 | SIS0092  | Se ha introducido una caducidad incorrecta.
| 9093 | SIS0093  | Denegación emisor
| 9094 | SIS0094  | Denegación emisor
| 9095 | SIS0095  | Denegación emisor
| 9096 | SIS0096  | El formato utilizado para los datos 3DSecure es incorrecto
| 9097 | SIS0097  | Valor del campo Ds_Merchant_CComercio no válido
| 9098 | SIS0098  | Valor del campo Ds_Merchant_CVentana no válido
| 9099 | SIS0099  | Error al interpretar respuesta de autenticación
| 9103 | SIS0103  | Error al montar la petición de Autenticación
| 9104 | SIS0104  | Comercio con “titular seguro” y titular sin clave de compra segura
| 9112 | SIS0112  | Que revise que está enviando en el campo Ds_Merchant_Transacction_Type.
| 9113 | SIS0113  | Error interno
| 9114 | SIS0114  | Se está realizando la llamada por GET, la tiene que realizar por POST
| 9115 | SIS0115  | Que revise los datos de la operación que nos está enviando
| 9116 | SIS0116  | La operación sobre la que se desea pagar una cuota no es una operación válida
| 9117 | SIS0117  | La operación sobre la que se desea pagar una cuota no está autorizada
| 9118 | SIS0118  | Se ha excedido el importe total de las cuotas
| 9119 | SIS0119  | Valor del campo Ds_Merchant_DateFrecuency no válido ( Pagos recurrentes)
| 9120 | SIS0120  | Valor del campo Ds_Merchant_ChargeExpiryDate no válido
| 9121 | SIS0121  | Valor del campo Ds_Merchant_SumTotal no válido
| 9122 | SIS0122  | Formato incorrecto del campo Ds_Merchant_DateFrecuency o Ds_Merchant_SumTotal
| 9123 | SIS0123  | Se ha excedido la fecha tope para realiza la Transacción
| 9124 | SIS0124  | No ha transcurrido la frecuencia mínima en un pago recurrente sucesivo
| 9125 | SIS0125  | Error genérico
| 9126 | SIS0126  | Operación Duplicada
| 9127 | SIS0127  | Error Interno
| 9128 | SIS0128  | Error interno
| 9129 | SIS0129  | Error, se ha detectado un intento masivo de peticiones desde la ip
| 9130 | SIS0130  | Error Interno
| 9131 | SIS0131  | Error Interno
| 9132 | SIS0132  | La fecha de Confirmación de Autorización no puede superar en mas de 7 dias a la de Preautorización.
| 9133 | SIS0133  | La fecha de Confirmación de Autenticación no puede superar en mas de 45 días a la de Autenticacion Previa que el comercio revise la fecha de la Preautenticación
| 9134 | SIS0134  | El valor del Ds_MerchantCiers enviado no es válido
| 9135 | SIS0135  | Error generando un nuevo valor para el IDETRA
| 9136 | SIS0136  | Error al montar el mensaje de notificación
| 9137 | SIS0137  | Error al intentar validar la tarjeta como 3DSecure NACIONAL
| 9138 | SIS0138  | Error debido a que existe una Regla del ficheros de reglas que evita que se produzca la Autorizacion
| 9139 | SIS0139  | pago recurrente inicial está duplicado
| 9140 | SIS0140  | Error Interno
| 9141 | SIS0141  | Error formato no correcto para 3DSecure
| 9142 | SIS0142  | Tiempo excecido para el pago
| 9151 | SIS0151  | Error Interno
| 9169 | SIS0169  | El valor del campo Ds_Merchant_MatchingData ( Datos de Case) no es valido , que lo revise
| 9170 | SIS0170  | Que revise el adquirente que manda en el campo
| 9171 | SIS0171  | Que revise el CSB que nos está enviando
| 9172 | SIS0172  | El valor del campo PUCE Ds_Merchant_MerchantCode no es válido
| 9173 | SIS0173  | Que el comercio revise el campo de la URL OK
| 9174 | SIS0174  | Error Interno
| 9175 | SIS0175  | Error Interno
| 9181 | SIS0181  | Error Interno
| 9182 | SIS0182  | Error Interno
| 9183 | SIS0183  | Error interno
| 9184 | SIS0184  | Error interno
| 9186 | SIS0186  | Faltan datos para operación
| 9187 | SIS0187  | Error formato( Interno )
| 9197 | SIS0197  | Error al obtener los datos de cesta de la compra
| 9214 | SIS0214  | Su comercion no permite devoluciones por el tipo de firma ( Completo)
| 9216 | SIS0216  | El CVV2 tiene mas de 3 posiciones
| 9217 | SIS0217  | Error de formato en el CVV2
| 9218 | SIS0218  | El comercio no permite operaciones seguras por las entradas "operaciones" o "WebService"
| 9219 | SIS0219  | Se tiene que dirigir a su entidad.
| 9220 | SIS0220  | Se tiene que dirigir a su entidad.
| 9221 | SIS0221  | El cliente no está introduciendo el CVV2
| 9222 | SIS0222  | Existe una anulación asociada a la preautorización
| 9223 | SIS0223  | La preautorización que se desea anular no está autorizada
| 9224 | SIS0224  | Su comercio no permite anulaciones por no tener la firma ampliada
| 9225 | SIS0225  | No existe operación sobre la que realizar la anulación
| 9226 | SIS0226  | Error en en los datos de la anulación manual
| 9227 | SIS0227  | Que el comercio revise el campo Ds_Merchant_TransactionDate
| 9228 | SIS0228  | El tipo de tarjeta no puede realizar pago aplazado
| 9229 | SIS0229  | Error con el codigo de aplazamiento
| 9230 | SIS0230  | Su comercio no permite pago fraccionado( Consulte a su entidad)
| 9231 | SIS0231  | No hay forma de pago aplicable ( Consulte con su entidad)
| 9232 | SIS0232  | Forma de pago no disponible
| 9233 | SIS0233  | Forma de pago desconocida
| 9234 | SIS0234  | Nombre del titular de la cuenta no disponible
| 9235 | SIS0235  | Campo Sis_Numero_Entidad no disponible
| 9236 | SIS0236  | El campo Sis_Numero_Entidad no tiene la longitud requerida
| 9237 | SIS0237  | El campo Sis_Numero_Entidad no es numérico
| 9238 | SIS0238  | Campo Sis_Numero_Oficina no disponible
| 9239 | SIS0239  | El campo Sis_Numero_Oficina no tiene la longitud requerida
| 9240 | SIS0240  | El campo Sis_Numero_Oficina no es numérico
| 9241 | SIS0241  | Campo Sis_Numero_DC no disponible
| 9242 | SIS0242  | El campo Sis_Numero_DC no tiene la longitud requerida
| 9243 | SIS0243  | El campo Sis_Numero_DC no es numérico
| 9244 | SIS0244  | Campo Sis_Numero_Cuenta no disponible
| 9245 | SIS0245  | El campo Sis_Numero_Cuenta no tiene la longitud requerida
| 9246 | SIS0246  | El campo Sis_Numero_Cuenta no es numérico
| 9247 | SIS0247  | Dígito de Control de Cuenta Cliente no válido
| 9248 | SIS0248  | El comercio no permite pago por domiciliación
| 9249 | SIS0249  | Error genérico
| 9250 | SIS0250  | Error genérico
| 9251 | SIS0251  | No permite transferencias( Consultar con entidad )
| 9252 | SIS0252  | Por su configuración no puede enviar la tarjeta. ( Para modificarlo consualtar con la entidad)
| 9253 | SIS0253  | No se ha tecleado correctamente la tarjeta.
| 9254 | SIS0254  | Se tiene que dirigir a su entidad.
| 9255 | SIS0255  | Se tiene que dirigir a su entidad.
| 9256 | SIS0256  | El comercio no permite operativa de preautorizacion.
| 9257 | SIS0257  | La tarjeta no permite operativa de preautorizacion
| 9258 | SIS0258  | Tienen que revisar los datos de la validación
| 9259 | SIS0259  | No existe la operacion original para notificar o consultar
| 9260 | SIS0260  | Entrada incorrecta al SIS
| 9261 | SIS0261  | Se tiene que dirigir a su entidad.
| 9262 | SIS0262  | Moneda no permitida para operación de transferencia o domiciliacion
| 9263 | SIS0263  | Error calculando datos para procesar operación
| 9264 | SIS0264  | Error procesando datos de respuesta recibidos
| 9265 | SIS0265  | Error de firma en los datos recibidos
| 9266 | SIS0266  | No se pueden recuperar los datos de la operación recibida
| 9267 | SIS0267  | La operación no se puede procesar por no existir Codigo Cuenta Cliente
| 9268 | SIS02648 | La devolución no se puede procesar por WebService
| 9269 | SIS0269  | No se pueden realizar devoluciones de operaciones de domiciliacion no descargadas
| 9270 | SIS0270  | El comercio no puede realizar preautorizaciones en diferido
| 9274 | SIS0274  | Tipo de operación desconocida o no permitida por esta entrada al SIS
| 9275 | SIS0275  | Premio sin IdPremio
| 9276 | SIS076   | Unidades del Premio no numericas.
| 9277 | SIS0277  | Error genérico. Consulte con Redsys
| 9278 | SIS0278  | Error en el proceso de consulta de premios
| 9279 | SIS0279  | El comercio no tiene activada la operativa de fidelización
| 9280 | SIS0280  | Se tiene que dirigir a su entidad.
| 9281 | SIS0281  | Se tiene que dirigir a su entidad.
| 9282 | SIS0282  | Se tiene que dirigir a su entidad.
| 9283 | SIS0283  | Se tiene que dirigir a su entidad.
| 9284 | SIS0284  | No existe operacion sobre la que realizar el Pago Adicional
| 9285 | SIS0285  | Tiene más de una operacion sobre la que realizar el Pago Adicional
| 9286 | SIS0286  | La operación sobre la que se quiere hacer la operación adicional no esta Aceptada
| 9287 | SIS0287  | la Operacion ha sobrepasado el importe para el Pago Adicional.
| 9288 | SIS0288  | No se puede realizar otro pago Adicional. se ha superado el numero de pagos
| 9289 | SIS0289  | El importe del pago Adicional supera el maximo días permitido.
| 9290 | SIS0290  | Se tiene que dirigir a su entidad.
| 9291 | SIS0291  | Se tiene que dirigir a su entidad.
| 9292 | SIS0292  | Se tiene que dirigir a su entidad.
| 9293 | SIS0293  | Se tiene que dirigir a su entidad.
| 9294 | SIS0294  | La tarjeta no es privada.
| 9295 | SIS0295  | duplicidad de operación. Se puede intentar de nuevo ( 1 minuto )
| 9296 | SIS0296  | No se encuentra la operación Tarjeta en Archivo inicial
| 9297 | SIS0297  | Número de operaciones sucesivas de Tarjeta en Archivo superado
| 9298 | SIS0298  | No puede realizar este tipo de operativa. (Contacte con su entidad)
| 9299 | SIS0299  | Error en pago con PayPal
| 9300 | SIS0300  | Error en pago con PayPal
| 9301 | SIS0301  | Error en pago con PayPal
| 9302 | SIS0302  | Moneda no válida para pago con PayPal
| 9304 | SIS0304  | No se permite pago fraccionado si la tarjeta no es de FINCONSUM
| 9305 | SIS0305  | Revisar la moneda de la operación
| 9306 | SIS0306  | Valor de Ds_Merchant_PrepaidCard no válido
| 9307 | SIS0307  | Que consulte con su entidad. Operativa de tarjeta regalo no permitida
| 9308 | SIS0308  | Tiempo límite para recarga de tarjeta regalo superado
| 9309 | SIS0309  | Faltan datos adicionales para realizar la recarga de tarjeta prepago
| 9310 | SIS0310  | Valor de Ds_Merchant_Prepaid_Expiry no válido
| 9311 | SIS0311  | Error genérico
| 9319 | SIS0319  | El comercio no pertenece al grupo especificado en Ds_Merchant_Group
| 9320 | SIS0320  | Error generando la referencia
| 9321 | SIS0321  | El identificador no está asociado al comercio
| 9322 | SIS0322  | Que revise el formato del grupo
| 9323 | SIS0323  | Para el tipo de operación F( pago en dos fases) es necesario enviar uno de estos campos. Ds_Merchant_Customer_Mobile o Ds_Merchant_Customer_Mail
| 9324 | SIS0324  | Imposible enviar el link al cliente( Que revise la dirección mail)
| 9326 | SIS0326  | Se han enviado datos de tarjeta en fase primera de un pago con dos fases
| 9327 | SIS0327  | No se ha enviado ni móvil ni email en fase primera de un pago con dos fases
| 9328 | SIS0328  | Token de pago en dos fases inválido
| 9329 | SIS0329  | No se puede recuperar el Token de pago en dos fases.
| 9330 | SIS0330  | Fechas incorrectas de pago dos fases
| 9331 | SIS0331  | La operación no tiene un estado válido o no existe.
| 9332 | SIS0332  | El importe de la operación original y de la devolución debe ser idéntico
| 9333 | SIS0333  | Error en una petición a MasterPass Wallet
| 9334 | SIS0334  | Bloqueo por control de Seguridad
| 9335 | SIS0335  | El valor del campo Ds_Merchant_Recharge_Commission no es válido
| 9336 | SIS0336  | Error genérico. Consulte con Redsys
| 9342 | SIS0342  | El comercio no permite realizar operaciones de pago de tributos
| 9343 | SIS0343  | Falta o es incorrecto el parámetro Ds_Merchant_Tax_Reference
| 9344 | SIS0344  | No se han aceptado las condiciones de las cuotas
| 9345 | SIS0345  | Se ha elegido un número de plazos incorrecto
| 9346 | SIS0346  | Error en el formato del campo DS_MERCHANT_PAY_TYPE
| 9347 | SIS0347  | El comercio no está configurado para realizar la consulta de BIN.
| 9348 | SIS0348  | El BIN indicado en la consulta no se reconoce
| 9349 | SIS0349  | Los datos de importe y DCC enviados no coinciden con los registrados en SIS
| 9350 | SIS0350  | No hay datos DCC registrados en SIS para este número de pedido
| 9351 | SIS0351  | Autenticación prepago incorrecta
| 9352 | SIS0352  | El tipo de firma del comercio no permite esta operativa
| 9353 | SIS0353  | El comercio no tiene definida una clave 3DES válida
| 9354 | SIS0354  | Error descifrando petición
| 9355 | SIS0355  | El comercio-terminal enviado en los datos cifrados no coincide con el enviado en la petición
| 9356 | SIS0356  | Existen datos de entrada para control de fraude y el comercio no tiene activo control de fraude
| 9357 | SIS0357  | El comercio tiene activo control de fraude y no existe campo ds_merchant_merchantscf
| 9370 | SIS0370  | Error en formato Scf_Merchant_Nif. Longitud máxima 16
| 9371 | SIS0371  | Error en formato Scf_Merchant_Name. Longitud máxima 30
| 9372 | SIS0372  | Error en formato Scf_Merchant_First_Name. Longitud máxima 30
| 9373 | SIS0373  | Error en formato Scf_Merchant_Last_Name. Longitud máxima 30
| 9374 | SIS0374  | Error en formato Scf_Merchant_User. Longitud máxima 45
| 9375 | SIS0375  | Error en formato Scf_Affinity_Card. Valores posibles 'S' o 'N'. Longitud máxima 1
| 9376 | SIS0376  | Error en formato Scf_Payment_Financed. Valores posibles 'S' o 'N'. Longitud máxima 1
| 9377 | SIS0377  | Error en formato Scf_Ticket_Departure_Point. Longitud máxima 30
| 9378 | SIS0378  | Error en formato Scf_Ticket_Destination. Longitud máxima 30
| 9379 | SIS0379  | Error en formato Scf_Ticket_Departure_Date. Debe tener formato yyyyMMddHHmmss.
| 9380 | SIS080   | Error en formato Scf_Ticket_Num_Passengers. Longitud máxima 1.
| 9381 | SIS081   | Error en formato Scf_Passenger_Dni. Longitud máxima 16.
| 9382 | SIS082   | Error en formato Scf_Passenger_Name. Longitud máxima 30.
| 9283 | SIS0334  | Se tiene que dirigir a su entidad.
| 9335 | SIS0335  | El valor del campo Ds_Merchant_Recharge_Commission no es válido
| 9336 | SIS0336  | Error genérico
| 9342 | SIS0342  | El comercio no permite realizar operaciones de pago de tributos
| 9343 | SIS0343  | Falta o es incorrecto el parámetro Ds_Merchant_Tax_Reference
| 9344 | SIS0344  | El usuario ha elegido aplazar el pago, pero no ha aceptado las condiciones de las cuotas
| 9345 | SIS0345  | Revisar el número de plazos que está enviando.
| 9346 | SIS0346  | Revisar formato en parámetro DS_MERCHANT_PAY_TYPE
| 9347 | SIS0347  | El comercio no está configurado para realizar la consulta de BIN.
| 9348 | SIS0348  | El BIN indicado en la consulta no se reconoce
| 9349 | SIS0349  | Los datos de importe y DCC enviados no coinciden con los registrados en SIS
| 9350 | SIS0350  | No hay datos DCC registrados en SIS para este número de pedido
| 9351 | SIS0351  | Autenticación prepago incorrecta
| 9352 | SIS0352  | El tipo de firma no permite esta operativa
| 9353 | SIS0353  | Clave no válida
| 9354 | SIS0354  | Error descifrando petición al SIS
| 9355 | SIS0355  | El comercio-terminal enviado en los datos cifrados no coincide con el enviado en la petición
| 9356 | SIS0356  | El comercio no tiene activo control de fraude ( Consulte con su entidad
| 9357 | SIS0357  | El comercio tiene activo control de fraude y no existe campo ds_merchant_merchantscf
| 9359 | SIS0359  | El comercio solamente permite pago de tributos y no se está informando el campo Ds_Merchant_TaxReference
| 9370 | SIS0370  | Error en formato Scf_Merchant_Nif. Longitud máxima 16
| 9371 | SIS0371  | Error en formato Scf_Merchant_Name. Longitud máxima 30
| 9372 | SIS0372  | Error en formato Scf_Merchant_First_Name. Longitud máxima 30
| 9373 | SIS0373  | Error en formato Scf_Merchant_Last_Name. Longitud máxima 30
| 9374 | SIS0374  | Error en formato Scf_Merchant_User. Longitud máxima 45
| 9375 | SIS0375  | Error en formato Scf_Affinity_Card. Valores posibles 'S' o 'N'. Longitud máxima 1
| 9376 | SIS0376  | Error en formato Scf_Payment_Financed. Valores posibles 'S' o 'N'. Longitud máxima 1
| 9377 | SIS0377  | Error en formato Scf_Ticket_Departure_Point. Longitud máxima 30
| 9378 | SIS0378  | Error en formato Scf_Ticket_Destination. Longitud máxima 30
| 9379 | SIS0379  | Error en formato Scf_Ticket_Departure_Date. Debe tener formato yyyyMMddHHmmss.
| 9380 | SIS0380  | Error en formato Scf_Ticket_Num_Passengers. Longitud máxima 1.
| 9381 | SIS0381  | Error en formato Scf_Passenger_Dni. Longitud máxima 16.
| 9382 | SIS0382  | Error en formato Scf_Passenger_Name. Longitud máxima 30.
| 9383 | SIS0383  | Error en formato Scf_Passenger_First_Name. Longitud máxima 30.
| 9384 | SIS0384  | Error en formato Scf_Passenger_Last_Name. Longitud máxima 30.
| 9385 | SIS0385  | Error en formato Scf_Passenger_Check_Luggage. Valores posibles 'S' o 'N'. Longitud máxima 1.
| 9386 | SIS0386  | Error en formato Scf_Passenger_Special_luggage. Valores posibles 'S' o 'N'. Longitud máxima 1.
| 9387 | SIS0387  | Error en formato Scf_Passenger_Insurance_Trip. Valores posibles 'S' o 'N'. Longitud máxima 1.
| 9388 | SIS0388  | Error en formato Scf_Passenger_Type_Trip. Valores posibles 'N' o 'I'. Longitud máxima 1.
| 9389 | SIS0389  | Error en formato Scf_Passenger_Pet. Valores posibles 'S' o 'N'. Longitud máxima 1.
| 9390 | SIS0390  | Error en formato Scf_Order_Channel. Valores posibles 'M'(móvil), 'P'(PC) o 'T'(Tablet)
| 9391 | SIS0391  | Error en formato Scf_Order_Total_Products. Debe tener formato numérico y longitud máxima de 3.
| 9392 | SIS0392  | Error en formato Scf_Order_Different_Products. Debe tener formato numérico y longitud máxima de 3.
| 9393 | SIS0393  | Error en formato Scf_Order_Amount. Debe tener formato numérico y longitud máxima de 19.
| 9394 | SIS0394  | Error en formato Scf_Order_Max_Amount. Debe tener formato numérico y longitud máxima de 19.
| 9395 | SIS0395  | Error en formato Scf_Order_Coupon. Valores posibles 'S' o 'N'
| 9396 | SIS0396  | Error en formato Scf_Order_Show_Type. Debe longitud máxima de 30.
| 9397 | SIS0397  | Error en formato Scf_Wallet_Identifier
| 9398 | SIS0398  | Error en formato Scf_Wallet_Client_Identifier
| 9399 | SIS0399  | Error en formato Scf_Merchant_Ip_Address
| 9400 | SIS0400  | Error en formato Scf_Merchant_Proxy
| 9401 | SIS0401  | Error en formato Ds_Merchant_Mail_Phone_Number. Debe ser numérico y de longitud máxima 19
| 9402 | SIS0402  | Error en llamada a SafetyPay para solicitar token url
| 9403 | SIS0403  | Error en proceso de solicitud de token url a SafetyPay
| 9404 | SIS0404  | Error en una petición a SafetyPay
| 9405 | SIS0405  | Solicitud de token url denegada SAFETYPAY
| 9406 | SIS0406  | Se tiene que poner en contacto con su entidad para que revisen la configuración del sector de actividad de su comercio
| 9407 | SIS0407  | El importe de la operación supera el máximo permitido para realizar un pago de premio de apuesta(Gambling)
| 9408 | SIS0408  | La tarjeta debe de haber operado durante el último año para poder realizar un pago de premio de apuesta (Gambling)
| 9409 | SIS0409  | La tarjeta debe ser una Visa o MasterCard nacional para realizar un pago de premio de apuesta (Gambling)
| 9410 | SIS0410  | Denegada por el emisor
| 9411 | SIS0411  | Error en la configuración del comercio (Remitir a su entidad)
| 9412 | SIS0412  | La firma no es correcta
| 9413 | SIS0413  | Denegada, consulte con su entidad.
| 9414 | SIS0414  | El plan de ventas no es correcto
| 9415 | SIS0415  | El tipo de producto no es correcto
| 9416 | SIS0416  | Importe no permitido en devolucion
| 9417 | SIS0417  | Fecha de devolucion no permitida
| 9418 | SIS0418  | No existe plan de ventas vigente
| 9419 | SIS0419  | Tipo de cuenta no permitida
| 9420 | SIS0420  | El comercio no dispone de formas de pago para esta operación
| 9421 | SIS0421  | Tarjeta no permitida. No es producto Agro
| 9422 | SIS0422  | Faltan datos para operacion Agro
| 9423 | SIS0423  | CNPJ del comecio incorrecto
| 9424 | SIS0424  | No se ha encontrado el establecimiento
| 9425 | SIS0425  | No se ha encontrado la tarjeta
| 9426 | SIS0426  | Enrutamiento no valido para el comercio
| 9427 | SIS0427  | La conexion con CECA no ha sido posible
| 9428 | SIS0428  | Operacion debito no segura
| 9429 | SIS0429  | Error en la versión enviada por el comercio (Ds_SignatureVersion)
| 9430 | SIS0430  | Error al decodificar el parámetro Ds_MerchantParameters
| 9431 | SIS0431  | Error del objeto JSON que se envía codificado en el parámetro Ds_MerchantParameters
| 9432 | SIS0432  | Error FUC del comercio erróneo
| 9433 | SIS0433  | Error Terminal del comercio erróneo
| 9434 | SIS0434  | Error ausencia de número de pedido en la op. del comercio
| 9435 | SIS0435  | Error en el cálculo de la firma
| 9436 | SIS0436  | Error en la construcción del elemento padre
| 9437 | SIS0437  | Error en la construcción del elemento
| 9438 | SIS0438  | Error en la construcción del elemento
| 9439 | SIS0439  | Error en la construcción del elemento
| 9440 | SIS0440  | Error genérico
| 9441 | SIS0441  | Error no tenemos bancos para Mybank
| 9442 | SIS0442  | Error genérico
| 9443 | SIS0443  | No se permite pago con esta tarjeta
| 9444 | SIS0444  | Se está intentando acceder usando firmas antiguas y el comercio está configurado como HMAC SHA256
| 9445 | SIS0445  | Error genérico
| 9446 | SIS0446  | Es obligatorio indicar la forma de pago
| 9447 | SIS0447  | Error, se está utilizando una referencia que se generó con un adquirente distinto al adquirente que la utiliza.
| 9448 | SIS0448  | El comercio no tiene el método de pago "Pago DINERS"
| 9449 | SIS0449  | Tipo de pago de la operación no permitido para este tipo de tarjeta
| 9450 | SIS0450  | Tipo de pago de la operación no permitido para este tipo de tarjeta
| 9451 | SIS0451  | Tipo de pago de la operación no permitido para este tipo de tarjeta
| 9453 | SIS0453  | No se permiten pagos con ese tipo de tarjeta
| 9454 | SIS0454  | No se permiten pagos con ese tipo de tarjeta
| 9455 | SIS0455  | No se permiten pagos con ese tipo de tarjeta
| 9456 | SIS0456  | No tiene método de pago configurado (Consulte a su entidad)
| 9457 | SIS0457  | Error, se aplica el método de pago "MasterCard SecureCode" con Respuesta [VEReq, VERes] = N con tarjeta MasterCard Comercial y el comercio no tiene el método de pago "MasterCard Comercial"
| 9458 | SIS0458  | Error, se aplica el método de pago "MasterCard SecureCode" con Respuesta [VEReq, VERes] = U con tarjeta MasterCard Comercial y el comercio no tiene el método de pago "MasterCard Comercial"
| 9459 | SIS0459  | No tiene método de pago configurado (Consulte a su entidad)
| 9460 | SIS0460  | No tiene método de pago configurado (Consulte a su entidad)
| 9461 | SIS0461  | No tiene método de pago configurado (Consulte a su entidad)
| 9462 | SIS0462  | Metodo de pago no disponible para conexión HOST to HOST
| 9463 | SIS0463  | Metodo de pago no permitido
| 9464 | SIS0464  | El comercio no tiene el método de pago "MasterCard Comercial"
| 9465 | SIS0465  | No tiene método de pago configurado (Consulte a su entidad)
| 9466 | SIS0466  | La referencia que se está utilizando no existe.
| 9467 | SIS0467  | La referencia que se está utilizando está dada de baja
| 9468 | SIS0468  | Se está utilizando una referencia que se generó con un adquirente distinto al adquirente que la utiliza.
| 9469 | SIS0469  | Error, no se ha superado el proceso de fraude MR
| 9470 | SIS0470  | Error la solicitud del primer factor ha fallado.
| 9471 | SIS0471  | Error en la URL de redirección de solicitud del primer factor.
| 9472 | SIS0472  | Error al montar la petición de Autenticación de PPII.
| 9473 | SIS0473  | Error la respuesta de la petición de Autenticación de PPII es nula.
| 9474 | SIS0474  | Error el statusCode de la respuesta de la petición de Autenticación de PPII es nulo
| 9475 | SIS0475  | Error el idOperación de la respuesta de la petición de Autenticación de PPII es nulo
| 9476 | SIS0476  | Error tratando la respuesta de la Autenticación de PPII
| 9477 | SIS0477  | Error se ha superado el tiempo definido entre el paso 1 y 2 de PPI
| 9478 | SIS0478  | Error tratando la respuesta de la Autorización de PPII
| 9479 | SIS0479  | Error la respuesta de la petición de Autorización de PPII es nula
| 9480 | SIS0480  | Error el statusCode de la respuesta de la petición de Autorización de PPII es nulo.
| 9481 | SIS0481  | Error, el comercio no es Payment Facilitator
| 9482 | SIS0482  | Error el idOperación de la respuesta de una Autorización OK es nulo o no coincide con el idOp. de la Auth.
| 9483 | SIS0483  | Error la respuesta de la petición de devolución de PPII es nula.
| 9484 | SIS0484  | Error el statusCode o el idPetición de la respuesta de la petición de Devolución de PPII es nulo.
| 9485 | SIS0485  | Error producido por la denegación de la devolución.
| 9486 | SIS0486  | Error la respuesta de la petición de consulta de PPII es nula.
| 9487 | SIS0487  | El comercio terminal no tiene habilitado el método de pago Paygold.
| 9488 | SIS0488  | El comercio no tiene el método de pago "Pago MOTO/Manual" y la operación viene marcada como pago MOTO.
| 9489 | SIS0489  | Error de datos. Operacion MPI Externo no permitida
| 9490 | SIS0490  | Error de datos. Se reciben parametros MPI Redsys en operacion MPI Externo
| 9491 | SIS0491  | Error de datos. SecLevel no permitido en operacion MPI Externo
| 9492 | SIS0492  | Error de datos. Se reciben parametros MPI Externo en operacion MPI Redsys
| 9493 | SIS0493  | Error de datos. Se reciben parametros de MPI en operacion no segura
| 9494 | SIS0494  | FIRMA OBSOLETA
| 9495 | SIS0495  | Configuración incorrecta ApplePay o AndroidPay
| 9496 | SIS0496  | No tiene dado de alta el método de pago AndroidPay
| 9497 | SIS0497  | No tiene dado de alta el método de pago ApplePay
| 9498 | SIS0498  | moneda / importe de la operación de ApplePay no coinciden
| 9499 | SIS0499  | Error obteniendo claves del comercio en Android/Apple Pay
| 9500 | SIS0500  | Error en el DCC Dinámico, se ha modificado la tarjeta.
| 9501 | SIS0501  | Error en La validación de datos enviados para genera el Id operación
| 9502 | SIS0502  | Error al validar Id Oper
| 9503 | SIS0503  | Error al validar el pedido
| 9504 | SIS0504  | Error al validar tipo de transacción
| 9505 | SIS0505  | Error al validar moneda
| 9506 | SIS0506  | Error al validar el importe
| 9507 | SIS0507  | Id Oper no tiene vigencia
| 9508 | SIS0508  | Error al validar Id Oper
| 9510 | SIS0510  | No se permite el envío de datos de tarjeta si se envía ID de operación
| 9511 | SIS0511  | Error en la respuesta de consulta de BINES
| 9515 | SIS0515  | El comercio tiene activado pago Amex en Perfil.
| 9516 | SIS0516  | Error al montar el mensaje de China Union Pay
| 9517 | SIS0517  | Error al establecer la clave para China Union Pay
| 9518 | SIS0518  | Error al grabar los datos para pago China Union Pay
| 9519 | SIS0519  | Mensaje de autenticación erróneo
| 9520 | SIS0520  | El mensaje SecurePlus de sesión está vacío
| 9521 | SIS0521  | El xml de respuesta viene vacío
| 9522 | SIS0522  | No se han recibido parametros en datosentrada
| 9523 | SIS0523  | La firma calculada no coincide con la recibida en la respuesta
| 9524 | SIS0524  | el resultado de la autenticación 3DSecure MasterCard es PARes="A" o VERes="N" y no recibimos CAVV del emisor
| 9525 | SIS0525  | No se puede utilizar la tarjeta privada en este comercio
| 9526 | SIS0526  | La tarjeta no es china
| 9527 | SIS0527  | Falta el parametro obligatorio DS_MERCHANT_BUYERID
| 9528 | SIS0528  | Formato erróneo del parametro DS_MERCHANT_BUYERID en operación Sodexo Brasil
| 9529 | SIS0529  | No se permite operación recurrente en pagos con tarjeta Voucher
| 9530 | SIS0530  | La fecha de Anulación no puede superar en mas de 7 dias a la de Preautorización.
| 9531 | SIS0531  | La fecha de Anulación no puede superar en mas de 72 horas a la de Preautorización diferida
| 9532 | SIS0532  | La moneda de la petición no coincide con la devuelta
| 9533 | SIS0533  | El importe de la petición no coincide con el devuelto
| 9534 | SIS0534  | No se recibe recaudación emisora o referencia del recibo
| 9535 | SIS0535  | Pago de tributo fuera de plazo
| 9536 | SIS0536  | Tributo ya pagado
| 9537 | SIS0537  | Pago de tributo denegado
| 9538 | SIS0538  | Rechazo en el pago de tributo
| 9539 | SIS0539  | Error en el envío de SMS
| 9540 | SIS0540  | El móvil enviado es demasiado largo (más de 12 posiciones)
| 9541 | SIS0541  | La referencia enviada es demasiada larga (más de 40 posiciones)
| 9542 | SIS0542  | Error genérico. Consulte con Redsys
| 9543 | SIS0543  | Error, la tarjeta de la operación es DINERS y el comercio no tiene el método de pago "Pago DINERS" o "Pago Discover No Seguro"
| 9544 | SIS0544  | Error, la tarjeta de la operación es DINERS y el comercio no tiene el método de pago "Pago Discover No Seguro"
| 9545 | SIS0545  | Error DISCOVER
| 9546 | SIS0546  | Error DISCOVER
| 9547 | SIS0547  | Error DISCOVER
| 9548 | SIS0548  | Error DISCOVER
| 9549 | SIS0549  | Error DISCOVER
| 9550 | SIS0550  | ERROR en el gestor de envío de los SMS. Consulte con Redsys
| 9551 | SIS0551  | ERROR en el proceso de autenticación.
| 9552 | SIS0552  | ERROR el resultado de la autenticacion PARes = 'U'
| 9553 | SIS0553  | ERROR se ha intentado hacer un pago con el método de pago UPI y la tarjeta no es china
| 9554 | SIS0554  | ERROR el resultado de la autenticacion para UPI es PARes = 'U' y el comercio no tiene métodos de pago no seguros UPI EXPRESSPAY
| 9555 | SIS0555  | ERROR la IP de conexión del módulo de administración no esta entre las permitidas.
| 9556 | SIS0556  | Se envía pago Tradicional y el comercio no tiene pago Tradicional mundial ni Tradicional UE.
| 9557 | SIS0557  | Se envía pago Tarjeta en Archivo y el comercio no tiene pago Tradicional mundial ni Tradicional UE.
| 9558 | SIS0558  | ERROR, el formato de la fecha dsMerchantP2FExpiryDate es incorrecto
| 9559 | SIS0559  | ERROR el id Operacion de la respuesta en la autenticación PPII es nulo o no se ha obtenido de la autenticación final
| 9560 | SIS0560  | ERROR al enviar la notificacion de autenticacion al comercio
| 9561 | SIS0561  | ERROR el idOperación de la respuesta de una confirmacion separada OK es nulo o no coincide con el idOp. de la Confirmacion.
| 9562 | SIS0562  | ERROR la respuesta de la petición de confirmacion separada de PPII es nula.
| 9563 | SIS0563  | ERROR tratando la respuesta de la confirmacion separada de PPII.
| 9564 | SIS0564  | ERROR chequeando los importes de DCC antes del envío de la operación a Stratus.
| 9565 | SIS0565  | Formato del importe del campo Ds_Merchant_Amount excede del límite permitido.
| 9566 | SIS0566  | Error de acceso al nuevo Servidor Criptográfico.
| 9567 | SIS0567  | ERROR se ha intentado hacer un pago con una tarjeta china UPI y el comercio no tiene método de pago UPI
| 9568 | SIS0568  | Operacion de consulta de tarjeta rechazada, tipo de transacción erróneo
| 9569 | SIS0569  | Operacion de consulta de tarjeta rechazada, no se ha informado la tarjeta
| 9570 | SIS0570  | Operacion de consulta de tarjeta rechazada, se ha enviado tarjeta y referencia
| 9571 | SIS0571  | Operacion de autenticacion rechazada, protocolVersion no indicado
| 9572 | SIS0572  | Operacion de autenticacion rechazada, protocolVersion no reconocido
| 9573 | SIS0573  | Operacion de autenticacion rechazada, browserAcceptHeader no indicado
| 9574 | SIS0574  | Operacion de autenticacion rechazada, browserUserAgent no indicado
| 9575 | SIS0575  | Operacion de autenticacion rechazada, browserJavaEnabled no indicado
| 9576 | SIS0576  | Operacion de autenticacion rechazada, browserLanguage no indicado
| 9577 | SIS0577  | Operacion de autenticacion rechazada, browserColorDepth no indicado
| 9578 | SIS0578  | Operacion de autenticacion rechazada, browserScreenHeight no indicado
| 9579 | SIS0579  | Operacion de autenticacion rechazada, browserScreenWidth no indicado
| 9580 | SIS0580  | Operacion de autenticacion rechazada, browserTZ no indicado
| 9581 | SIS0581  | Operacion de autenticacion rechazada, datos DS_MERCHANT_EMV3DS no está indicado o es demasiado grande y no se puede convertir en JSON
| 9582 | SIS0582  | Operacion de autenticacion rechazada, threeDSServerTransID no indicado
| 9583 | SIS0583  | Operacion de autenticacion rechazada, threeDSCompInd no indicado
| 9584 | SIS0584  | Operacion de autenticacion rechazada, notificationURL no indicado
| 9585 | SIS0585  | Operacion de autenticacion EMV3DS rechazada, no existen datos en la BBDD
| 9586 | SIS0586  | Operacion de autenticacion rechazada, PARes no indicado
| 9587 | SIS0587  | Operacion de autenticacion rechazada, MD no indicado
| 9588 | SIS0588  | Operacion de autenticacion rechazada, la versión no coincide entre los mensajes AuthenticationData y ChallengeResponse
| 9589 | SIS0589  | Operacion de autenticacion rechazada, respuesta sin CRes
| 9590 | SIS0590  | Operacion de autenticacion rechazada, error al desmontar la respuesta CRes
| 9591 | SIS0591  | Operacion de autenticacion rechazada, error la respuesta CRes viene sin threeDSServerTransID
| 9592 | SIS0592  | Operacion de autenticacion rechazada, error el transStatus del CRes no coincide con el transStatus de la consulta final de la operación
| 9593 | SIS0593  | Operacion de autenticacion rechazada, error el transStatus de la consulta final de la operación no está definido
| 9594 | SIS0594  | Operacion de autenticacion rechazada, CRes no indicado
| 9595 | SIS0595  | El comercio indicado no tiene métodos de pago seguros permitidos en 3DSecure V2
| 9596 | SIS0596  | Operacion de consulta de tarjeta rechazada,moneda errónea
| 9597 | SIS0597  | Operacion de consulta de tarjeta rechazada,importe erróneo
| 9598 | SIS0598  | Autenticación 3DSecure v2 errónea, y no se permite hacer fallback a 3DSecure v1
| 9599 | SIS0599  | Error en el proceso de autenticación 3DSecure v2
| 9600 | SIS0600  | Error en el proceso de autenticación 3DSecure v2 - Respuesta Areq N
| 9601 | SIS0601  | Error en el proceso de autenticación 3DSecure v2 - Respuesta Areq R
| 9602 | SIS0602  | Error en el proceso de autenticación 3DSecure v2 - Respuesta Areq U y el comercio no tiene método de pago U
| 9603 | SIS0603  | Error en el parámetro DS_MERCHANT_DCC de DCC enviado en operacion H2H (REST y SOAP)
| 9604 | SIS0604  | Error en los datos de DCC enviados en el parámetro DS_MERCHANT_DCC en operacion H2H (REST y SOAP)
| 9605 | SIS0605  | Error en el parámetro DS_MERCHANT_MPIEXTERNAL enviado en operacion H2H (REST y SOAP)
| 9606 | SIS0606  | Error en los datos de MPI enviados en el parámetro DS_MERCHANT_MPIEXTERNAL en operacion H2H (REST y SOAP)
| 9607 | SIS0607  | Error del parámetro TXID de MPI enviado en el parámetro DS_MERCHANT_MPIEXTERNAL en operacion H2H (REST y SOAP) es erróneo
| 9608 | SIS0608  | Error del parámetro CAVV de MPI enviado en el parámetro DS_MERCHANT_MPIEXTERNAL en operacion H2H (REST y SOAP) es erróneo
| 9609 | SIS0609  | Error del parámetro ECI de MPI enviado en el parámetro DS_MERCHANT_MPIEXTERNAL en operacion H2H (REST y SOAP) es erróneo
| 9610 | SIS0610  | Error del parámetro threeDSServerTransID de MPI enviado en el parámetro DS_MERCHANT_MPIEXTERNAL en operacion H2H (REST y SOAP) es erróneo
| 9611 | SIS0611  | Error del parámetro dsTransID de MPI enviado en el parámetro DS_MERCHANT_MPIEXTERNAL en operacion H2H (REST y SOAP) es erróneo
| 9612 | SIS0612  | Error del parámetro authenticacionValue de MPI enviado en el parámetro DS_MERCHANT_MPIEXTERNAL en operacion H2H (REST y SOAP) es erróneo
| 9613 | SIS0613  | Error del parámetro protocolVersion de MPI enviado en el parámetro DS_MERCHANT_MPIEXTERNAL en operacion H2H (REST y SOAP) es erróneo
| 9614 | SIS0614  | Error del parámetro Eci de MPI enviado en el parámetro DS_MERCHANT_MPIEXTERNAL en operacion H2H (REST y SOAP) es erróneo
| 9615 | SIS0615  | Error en MPI Externo, marca de tarjeta no permitida en SIS para MPI Externo
| 9616 | SIS0616  | Error del parámetro DS_MERCHANT_EXCEP_SCA tiene un valor erróneo
| 9617 | SIS0617  | Error del parámetro DS_MERCHANT_EXCEP_SCA es de tipo MIT y no vienen datos de COF o de pago por referencia
| 9618 | SIS0618  | Error la exención enviada no está permitida y el comercio no está preparado para autenticar
| 9619 | SIS0619  | Se recibe orderReferenceId de Amazon y no está el método de pago configurado
| 9620 | SIS0620  | Error la operación de DCC tiene asociado un markUp más alto del permitido, se borran los datos de DCC
| 9621 | SIS0621  | El amazonOrderReferenceId no es válido
| 9622 | SIS0622  | Error la operación original se hizo sin marca de Nuevo modelo DCC y el comercio está configurado como Nuevo Modelo DCC
| 9623 | SIS0623  | Error la operación original se hizo con marca de Nuevo modelo DCC y el comercio no está configurado como Nuevo Modelo DCC
| 9624 | SIS0624  | Error la operación original se hizo con marca de Nuevo modelo DCC pero su valor difiere del modelo configurado en el comercio
| 9625 | SIS0625  | Error en la anulación del pago, porque ya existe una devolución asociada a ese pago
| 9626 | SIS0626  | Error en la devolución del pago, ya existe una anulación de la operación que se desea devolver
| 9627 | SIS0627  | El número de referencia o solicitud enviada por CRTM no válida.
| 9628 | SIS0628  | Error la operación de viene con datos de 3DSecure y viene por la entrada SERMEPA
| 9629 | SIS0629  | Error no existe la operación de confirmación separada sobre la que realizar la anulación
| 9630 | SIS0630  | Error en la anulación de confirmación separada, ya existe una devolución asociada a la confirmación separada
| 9631 | SIS0631  | Error en la anulación de confirmación separada, ya existe una anulación asociada a la confirmación separada
| 9632 | SIS0632  | Error la confirmacion separada sobre la que se desea anular no está autorizada
| 9633 | SIS0633  | La fecha de Anulación no puede superar en los días configurados a la confirmacion separada.
| 9634 | SIS0634  | Error no existe la operación de pago sobre la que realizar la anulación
| 9635 | SIS0635  | Error en la anulación del pago, ya existe una anulación asociada al pago
| 9636 | SIS0636  | Error el pago que se desea anular no está autorizado
| 9637 | SIS0637  | La fecha de Anulación no puede superar en los días configurados al pago.
| 9638 | SIS0638  | Error existe más de una devolución que se quiere anular y no se ha especificado cual.
| 9639 | SIS0639  | Error no existe la operación de devolución sobre la que realizar la anulación
| 9640 | SIS0640  | Error la confirmacion separada sobre la que se desea anular no está autorizada o ya está anulada
| 9641 | SIS0641  | La fecha de Anulación no puede superar en los días configurados a la devolución.
| 9642 | SIS0642  | La fecha de la preautorización que se desea reemplazar no puede superar los 30 días de antigüedad
| 9643 | SIS0643  | Error al obtener la personalización del comercio
| 9644 | SIS0644  | Error en el proceso de autenticación 3DSecure v2 - Se envían datos de la entrada IniciaPetición a la entrada TrataPetición
| 9650 | SIS0650  | Error, la MAC no es correcta en la mensajeria de pago de tributos
| 9651 | SIS0651  | Error la exención exige SCA y el comercio no está preparado para autenticar
| 9652 | SIS0652  | Error la exención y la configuración del comercio exigen no SCA y el comercio no está configurado para autorizar con dicha marca de tarjeta
| 9653 | SIS0653  | Operacion de autenticacion rechazada, browserJavascriptEnabled no indicado
| 9654 | SIS0654  | Error, se indican datos de 3RI en Inicia Petición y la versión que se envía en el trataPetición no es 2.2
| 9655 | SIS0655  | Error, se indican un valor de Ds_Merchant_3RI_Ind no permitido
| 9656 | SIS0656  | Error, se indican un valor Ds_Merchant_3RI_Ind diferentes en el Inicia Petición y en el trataPetición
| 9657 | SIS0657  | Error, se indican datos de 3RI pero están incompletos
| 9658 | SIS0658  | Error, el parámetro threeRITrasactionID es erróneo o no se encuentran datos de operación original
| 9659 | SIS0659  | Error, los datos de FUC y Terminal obtenidos del threeRITrasactionID no corresponden al comercio que envía la operación
| 9660 | SIS0660  | Error, se indican datos de 3RI-OTA para Master y el campo authenticationValue en el trataPetición es vacío
| 9661 | SIS0661  | Error, se indican datos de 3RI-OTA para Master y el campo Eci en el trataPetición es vacío
| 9662 | SIS0662  | Error, el comercio no está entre los permitidos para realizar confirmaciones parciales.
| 9663 | SIS0663  | No existe datos de Inicia Petición que concuerden con los enviados por el comercio en el mensaje Trata Petición
| 9664 | SIS0664  | No se envía el elemento Id Transaccion 3DS Server en el mensaje Trata Petición y dicho elemento existe en el mensaje Inicia Petición
| 9665 | SIS0665  | La moneda indicada por el comercio en el mensaje Trata Petición no corresponde con la enviada en el mensaje Inicia Petición
| 9666 | SIS0666  | El importe indicado por el comercio en el mensaje Trata Petición no corresponde con el enviado en el mensaje Inicia Petición
| 9667 | SIS0667  | El tipo de operación indicado por el comercio en el mensaje Trata Petición no corresponde con el enviado en el mensaje Inicia Petición
| 9668 | SIS0668  | La referencia indicada por el comercio en el mensaje Trata Petición no corresponde con la enviada en el mensaje Inicia Petición
| 9669 | SIS0669  | El Id Oper Insite indicado por el comercio en el mensaje Trata Petición no corresponde con el enviado en el mensaje Inicia Petición
| 9670 | SIS0670  | La tarjeta indicada por el comercio en el mensaje Trata Petición no corresponde con la enviada en el mensaje Inicia Petición
| 9671 | SIS0671  | Denegación por TRA Lynx
| 9672 | SIS0672  | Bizum. Fallo en la autenticación. Bloqueo tras tres intentos.
| 9673 | SIS0673  | Bizum. Operación cancelada. El usuario no desea seguir.
| 9674 | SIS0674  | Bizum. Abono rechazado por beneficiario.
| 9675 | SIS0675  | Bizum. Cargo rechazado por ordenante.
| 9676 | SIS0676  | Bizum. El procesador rechaza la operación.
| 9677 | SIS0677  | Bizum. Saldo disponible insuficiente.
| 9678 | SIS0678  | La versión de 3DSecure indicada en el Trata Petición es errónea o es superior a la devuelva en el inicia petición
| 9680 | SIS0680  | Error en la autenticación EMV3DS y la marca no permite hacer fallback a 3dSecure 1.0
| 9681 | SIS0681  | Error al insertar los datos de autenticación en una operación con MPI Externo
| 9682 | SIS0682  | Error la operación es de tipo Consulta de TRA y el parámetro Ds_Merchant_TRA_Data es erróneo
| 9683 | SIS0683  | Error la operación es de tipo Consulta de TRA Fase 1 y falta el parámetro Ds_Merchant_TRA_Type
| 9684 | SIS0684  | Error la operación es de tipo Consulta de TRA Fase 1 y el parámetro Ds_Merchant_TRA_Type tiene un valor no permitido
| 9685 | SIS0685  | Error la operación es de tipo Consulta de TRA Fase 1 y el perfil del comercio no le permite exención TRA
| 9686 | SIS0686  | Error la operación es de tipo Consulta de TRA Fase 1 y la confifguración del comercio no le permite usar el TRA de Redsys
| 9687 | SIS0687  | Error la operación es de tipo Consulta de TRA Fase 2 y falta el parámetro Ds_Merchant_TRA_Result o tiene un valor no permitido
| 9688 | SIS0688  | Error la operación es de tipo Consulta de TRA Fase 2 y falta el parámetro Ds_Merchant_TRA_Method o tiene un valor erróneo
| 9689 | SIS0689  | Error la operación es de tipo Consulta de TRA Fase 2, no existe una operación concreta de Fase 1
| 9690 | SIS0690  | Error la operación es de tipo Consulta de TRA Fase 2 y obtenemos un error en la respuesta de Lynx
| 9691 | SIS0691  | Se envían datos SamsungPay y el comercio no tiene dado de alta el método de pago SamsungPay
| 9692 | SIS0692  | Se envía petición con firma de PSP y el comercio no tiene asociado un PSP.
| 9693 | SIS0693  | No se han obtenido correctamente los datos enviados por SamsungPay.
| 9694 | SIS0694  | No ha podido realizarse el pago con SamsungPay
| 9700 | SIS0700  | PayPal ha devuelto un KO
| 9754 | SIS0754  | Autenticación en 3DSecure V1 Obsoleta
| 9802 | SIS0802  | Envia un valor incorrecto en el parémtro DS_MERCHANT_COF_TYPE
| 9812 | SIS0812  | Error obteniendo los parametros XPAYDECODEDDATA
| 9813 | SIS0813  | Error obteniendo los parametros del parámetro Ds_Merchant_BrClientData
| 9814 | SIS0814  | Error el tipo de operación enviado en el segundo trataPetición no coincide con el de la operación
| 9815 | SIS0815  | Error, ya existe una operación de Paygold con los mismos datos en proceso de autorizar o ya autorizada
| 9816 | SIS0816  | Error en operación con XPAY. Operación con token y sin criptograma
| 9817 | SIS0817  | Operacion aunteticada por 3RI no se puede procesar por estado incorrecto
| 9818 | SIS0818  | Operacion autenticada por 3RI no se puede procesar por moneda incorrecta
| 9819 | SIS0819  | Operacion autenticada por 3RI no se puede procesar por importe incorrecto
| 9820 | SIS0820  | Operacion autenticada por 3RI no se puede procesar por estar expirada
| 9821 | SIS0821  | Operacion 3RI no encontrada, ID_OPER_3RI incorrecto
| 9822 | SIS0822  | Importe incorrecto en datos adicionales de autenticacion 3RI. El importe total acumulado supera el importe de la autenticacion
| 9823 | SIS0823  | Operacion autenticada por 3RI no se puede procesar, la marca de tarjeta no tiene su método de pago asociado
| 9824 | SIS0824  | Error registrando datos 3RI
| 9836 | SIS0836  | Error, no existe operación original de paygold con los datos proporcionados
| 9837 | SIS0837  | Error, la fecha indicada en el parámetro Ds_Merchant_P2f_ExpiryDate no tiene un formato correcto o está vacía
| 9843 | SIS0843  | Error en los datos Ds_Merchant_TokenData.
| 9844 | SIS0844  | El perfil del comercio no está configurado para aceptar devoluciones de tributos.
| 9850 |    9850  | Error en operación realizada con Amazon Pay
| 9860 |    9860  | Error en operación realizada con Amazon Pay. Se puede reintentar la operación
| 9899 |    9899  | No están correctamente firmados los datos que nos envían en el Ds_Merchant_Data.
| 9900 |    9900  | SafetyPay ha devuelto un KO
| 9909 |    9909  | Error interno
| 9912 |    9912  | Emisor no disponible
| 9913 |    9913  | Excepción en el envío SOAP de la notificacion
| 9914 |    9914  | Respuesta KO en el envío SOAP de la notificacion
| 9915 | SIS9915  | Cancelado por el titular
| 9928 |    9928  | El titular ha cancelado la preautorización
| 9929 |    9929  | El titular ha cancelado la operación
| 9930 |    9930  | La transferencia está pendiente
| 9931 |    9931  | Consulte con su entidad
| 9932 |    9932  | Denegada por Fraude (LINX)
| 9933 |    9933  | Denegada por Fraude (LINX)
| 9934 |    9934  | Denegada ( Consulte con su entidad)
| 9935 |    9935  | Denegada ( Consulte con su entidad)
| 9966 |    9966  | BIZUM ha devuelto un KO en la autorización
| 9992 |    9992  | Solicitud de PAE
| 9994 |    9994  | No ha seleccionado ninguna tarjeta de la cartera.
| 9995 |    9995  | Recarga de prepago denegada
| 9996 |    9996  | No permite la recarga de tarjeta prepago
| 9997 |    9997  | Con una misma tarjeta hay varios pagos en "vuelo" en el momento que se finaliza uno el resto se deniegan con este código. Esta restricción se realiza por seguridad.
| 9998 |    9998  | Operación en proceso de solicitud de datos de tarjeta
| 9999 |    9999  | Operación que ha sido redirigida al emisor a autenticar
|  101 |     101  | Tarjeta caducada
|  106 |     106  | Tarjeta bloqueada, exceso de pin erróneo
|  129 |     129  | Código de seguridad CVV incorrecto.
|  180 |     180  | Denegación emisor
|  184 |     184  | el cliente de la operación no se ha autenticado
|  190 |     190  | Denegación emisor
|  904 |     904  | Problema con la configuración de su comercio. Dirigirse a la entidad.
|      | XML0000  | Errores en el proceso del XML-String recibido
|      | XML0001  | Error en la generación del DOM a partir del XML-String recibido y la DTD definida
|      | XML0002  | No existe el elemento "Message" en el XML-String recibido
|      | XML0003  | El tipo de "Message" en el XML-String recibido tiene un valor desconcido o inválido en la petición
|      | XML0004  | No existe el elemento "Ds_MerchantCode" en el XML-String recibido
|      | XML0005  | El elemento "Ds_MerchantCode" viene vacío en el XML-String recibido
|      | XML0006  | El elemento "Ds_MerchantCode" tiene una longitud incorrecta en el XML-String recibido
|      | XML0007  | El elemento "Ds_MerchantCode" no tiene formato numérico en el XML-String recibido
|      | XML0008  | No existe el elemento "Ds_Terminal" en el XML-String recibido
|      | XML0009  | El elemento "Ds_Terminal" viene vacío en el XML-String recibido
|      | XML0010  | El elemento "Ds_Terminal" tiene una longitud incorrecta en el XML-String recibido
|      | XML0011  | El elemento "Ds_Terminal" no tiene formato numérico en el XML-String recibido
|      | XML0012  | No existe el elemento "Ds_Order" en el XML-String recibido
|      | XML0013  | El elemento "Ds_Order" viene vacío en el XML-String recibido
|      | XML0014  | El elemento "Ds_Order" tiene una longitud incorrecta en el XML-String recibido
|      | XML0015  | El elemento "Ds_Order" no tiene sus 4 primeras posiciones numéricas en el XML-String recibido
|      | XML0016  | No existe el elemento "Ds_TransactionType" en el XML-String recibido
|      | XML0017  | El elemento "Ds_TransactionType" viene vacío en el XML-String recibido
|      | XML0018  | El elemento "Ds_TransactionType" tiene una longitud incorrecta en el XML-String recibido
|      | XML0019  | El elemento "Ds_TransactionType" no tiene formato numérico en el XML-String recibido
|      | XML0020  | El elemento "Ds_TransactionType" tiene un valor desconcido o inválido en un mensaje Transaction
|      | XML0021  | No existe el elemento "Signature" en el XML-String recibido
|      | XML0022  | El elemento "Signature" viene vacío en el XML-String recibido
|      | XML0023  | La firma no es correcta
|      | XML0024  | No existen operaciones para los datos solicitados
|      | XML0025  | El XML de respuesta está mal formado
|      | XML0026  | No existe el elemento "Ds_fecha_inicio" en el XML-String recibido
|      | XML0027  | No existe el elemento "Ds_fecha_fin" en el XML-String recibido
|      | XML0028  | El comercio-terminal está dado de baja
|      | XML0029  | El elemento "SignatureVersion" viene vacío en el XML-String recibido
|      | XML0030  | El elemento "SignatureVersion" viene con un valor erróneo en el XML-String recibido
|      | XML0031  | El elemento "Entrada" viene con un valor no permitido en el XML-String recibido
|      | XML0032  | El elemento "Autorizada" viene con un valor no permitido en el XML-String recibido
|      | XML0033  | El elemento "ImporteMayor" viene con un valor no permitido en el XML-String recibido
|      | XML0034  | El elemento "ImporteMenor" viene con un valor no permitido en el XML-String recibido
|      | XML0035  | El elemento "Autenticada" viene con un valor no permitido en el XML-String recibido
|      | XML0036  | El elemento "DCC" viene con un valor no permitido en el XML-String recibido
|      | XML0037  | El elemento "Paymethod" viene con un valor no permitido en el XML-String recibido
|      | XML0038  | Error el elemento "Ds_fecha_inicio" es anterior a un año
|      | XML0039  | Error la difernecia entre "Ds_fecha_inicio" y "Ds_fecha_fin" excede los 15 días
|      | XML0040  | Error la "Ds_fecha_fin" es anterior a "Ds_fecha_inicio"
|      | XML0041  | Error el comercio no puede utilizar la consulta SOAP

## Códigos Ds_Response

En el caso que se realice la operación correctamente, el resultado de ésta será el resultado del parámetro "Ds_Response":

|   Código    | Significado |
|-------------|-------------|
| 0000 a 0099 | Transacción autorizada para pagos y preautorizaciones
| 0900        | Transacción autorizada para devoluciones y confirmaciones
| 0400        | Transacción autorizada para anulaciones
| 0101        | Tarjeta caducada
| 0102        | Tarjeta en excepción transitoria o bajo sospecha de fraude
| 0106        | Intentos de PIN excedidos
| 0125        | Tarjeta no efectiva
| 0129        | Código de seguridad (CVV2/CVC2) incorrecto
|  172        | Denegada, no repetir.
|  173        | Denegada, no repetir sin actualizar datos de tarjeta.
|  174        | Denegada, no repetir antes de 72 horas.
| 0180        | Tarjeta ajena al servicio
| 0184        | Error en la autenticación del titular
| 0190        | Denegación del emisor sin especificar motivo
| 0191        | Fecha de caducidad errónea
| 0195        | Requiere autenticación SCA
| 0202        | Tarjeta en excepción transitoria o bajo sospecha de fraude con retirada de tarjeta
| 0904        | Comercio no registrado en FUC
| 0909        | Error de sistema
| 0913        | Pedido repetido
| 0944        | Sesión Incorrecta
| 0950        | Operación de devolución no permitida
| 9912/0912   | Emisor no disponible
| 9064        | Número de posiciones de la tarjeta incorrecto
| 9078        | Tipo de operación no permitida para esa tarjeta
| 9093        | Tarjeta no existente
| 9094        | Rechazo servidores internacionales
| 9104        | Comercio con "titular seguro" y titular sin clave de compra segura
| 9218        | El comercio no permite op. seguras por entrada /operaciones
| 9253        | Tarjeta no cumple el check-digit
| 9256        | El comercio no puede realizar preautorizaciones
| 9257        | Esta tarjeta no permite operativa de preautorizaciones
| 9261        | Operación detenida por superar el control de restricciones en la entrada al SIS
| 9915        | A petición del usuario se ha cancelado el pago
| 9997        | Se está procesando otra transacción en SIS con la misma tarjeta
| 9998        | Operación en proceso de solicitud de datos  de tarjeta
| 9999        | Operación que ha sido redirigida al emisor a autenticar