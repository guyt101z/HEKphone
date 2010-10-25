<?php
class sfWidgetFormSchemaFormatterNone extends sfWidgetFormSchemaFormatter {
    protected
        $rowFormat = '%error%%field%<br />%help%',
        $helpFormat = '<span class="help">%help%</span>',
        $errorRowFormat = '<span>%errors%</span>',
        $errorListFormatInARow = '%errors%',
        $errorRowFormatInARow = '<div class="formError">&darr;&nbsp;%error%&nbsp;&darr;</div>',
        $namedErrorRowFormatInARow = '%name%: %error%<br />',
        $decoratorFormat = '%content%';
}
