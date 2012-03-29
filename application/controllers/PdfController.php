<?php

class PdfController extends Zend_Controller_Action {

    private $_entityManager;

    public function init() {

        $this->_entityManager = \Zend_Registry::get('DoctrineEntityManager');
    }

    public function indexAction() {
  
        $this->getHelper('viewRenderer')->setNoRender();
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $pdf = new Zend_Pdf();

// Add new page to the document
        $page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
        $pdf->pages[] = $page;

        // define font resource
        $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
        $date = new Zend_Date();
        $image = Zend_Pdf_Image::imageWithPath('images/MEDDS.png');
        // set font for page
        // write text to page
         $page->drawImage($image, 72, 820, 800, 400);

        $page->setFont($font, 24)
                ->drawText('Patient', 72, 720);

        $page->setFont($font, 12)
                ->drawText('Your books:', 72, 700);
        
        $patient = $this->getRequest()->getParams('list');
        
        foreach ($patient as $key => $value) {

            $count++;

            if ($count & 1) {
                ?> <tr class="d0"> <?php
        } else {
                ?> <tr id="d1"> <?php
        }

        $myVar = $value['patient'];
        $type = $value['patientType'];
        foreach ($value['assignedPhysician'] as $newKey => $value2) {
            $assignedPhysician = "Dr. " . $value2['firstName'] . " " . $value2['lastName'];
        }
            ?>
                <td><?php echo $myVar['lastName']; ?></td>
                <td><?php echo $myVar['firstName']; ?></td>
                <td><?php echo $myVar['address']; ?></td>
                <td><?php echo $assignedPhysician; ?></td>
                <td><?php echo $type; ?></td>
<?php
$books = $myVar['firstName'] . " " . $myVar['lastName'];
            $page->drawText($books, 72);
            ?></td>
            </tr>
        </table>
<?php
        } 
        $page->setFont($font, 16)
                ->drawText('Date: ' . $date, 40, 820)
                ->drawText('Keep this receipt for your records.', 72, 320);

        // add page to document
        $pdf->pages[] = $page;

        // save as file
        $pdfData = $pdf->render();

        header("Content-Disposition: inline; filename=result.pdf");
        header("Content-type: application/x-pdf");
        echo $pdfData;
  
      
    }
       
  

}