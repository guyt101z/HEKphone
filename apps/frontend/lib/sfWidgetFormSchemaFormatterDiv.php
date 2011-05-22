<?php
class sfWidgetFormSchemaFormatterDiv extends sfWidgetFormSchemaFormatter {
    protected
        $rowFormat = "<div class=\"entry\">%label%%field%%error%%help%</div>\n",
        $helpFormat = '<span class="help">%help%</span>',
        $errorRowFormat = '<span class="globalError">%errors%</span>',
        $errorListFormatInARow = '%errors%',
        $errorRowFormatInARow = "<span class=\"formError\">%error%</span>\n",
        $namedErrorRowFormatInARow = '%name%: %error%<br />',
        $decoratorFormat = '<div class="guardForm">%content%</div>';
}