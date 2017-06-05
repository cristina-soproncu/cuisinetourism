<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Application\Entity\Post;

/**
 * This form is used to collect post data.
 */
class PostForm extends Form
{
    /**
     * Constructor.     
     */
    public function __construct()
    {
        // Define form name
        parent::__construct('post-form');
     
        // Set POST method for this form
        $this->setAttribute('method', 'post');

        // Set binary content encoding.
        $this->setAttribute('enctype', 'multipart/form-data');
                
        $this->addElements();
        $this->addInputFilter();  
        
    }
    
    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements() 
    {
                
        // Add "title" field
        $this->add([        
            'type'  => 'text',
            'name' => 'title',
            'attributes' => [
                'id' => 'title'
            ],
            'options' => [
                'label' => 'Title',
            ],
        ]);
        
        // Add "description" field
        $this->add([
            'type'  => 'textarea',
            'name' => 'description',
            'attributes' => [                
                'id' => 'description'
            ],
            'options' => [
                'label' => 'Description',
            ],
        ]);

        // Add "binomial_name" field
        $this->add([
            'type'  => 'text',
            'name' => 'binomial_name',
            'attributes' => [
                'id' => 'binomial_name'
            ],
            'options' => [
                'label' => 'Binomial Name',
            ],
        ]);

        // Add "family" field
        $this->add([
            'type'  => 'text',
            'name' => 'family',
            'attributes' => [
                'id' => 'family'
            ],
            'options' => [
                'label' => 'Family',
            ],
        ]);

        // Add "genus" field
        $this->add([
            'type'  => 'text',
            'name' => 'genus',
            'attributes' => [
                'id' => 'genus'
            ],
            'options' => [
                'label' => 'Genus',
            ],
        ]);

        // Add "national_country" field
        $this->add([
            'type'  => 'text',
            'name' => 'national_country',
            'attributes' => [
                'id' => 'national_country'
            ],
            'options' => [
                'label' => 'National Country',
            ],
        ]);

        // Add "city" field
        $this->add([
            'type'  => 'text',
            'name' => 'city',
            'attributes' => [
                'id' => 'city'
            ],
            'options' => [
                'label' => 'Recommended City',
            ],
        ]);

        // Add "image" field
        $this->add([
            'type'  => 'file',
            'name' => 'image',
            'attributes' => [
                'id' => 'image'
            ],
            'options' => [
                'label' => 'Featured Image',
            ],
        ]);

        // Add "short_description" field
        $this->add([
            'type'  => 'textarea',
            'name' => 'short_description',
            'attributes' => [
                'id' => 'short_description'
            ],
            'options' => [
                'label' => 'Short Description',
            ],
        ]);

        // Add "bloom_start" field
        $this->add([
            'type'  => 'select',
            'name' => 'bloom_start',
            'attributes' => [
                'id' => 'bloom_start'
            ],
            'options' => [
                'label' => 'Start of blooming',
                'value_options' => [
                    1 => 'January',
                    2 => 'February',
                    3 => 'March',
                    4 => 'April',
                    5 => 'May',
                    6 => 'June',
                    7 => 'July',
                    8 => 'August',
                    9 => 'September',
                    10 => 'October',
                    11 => 'Novemeber',
                    12 => 'December'
                ]
            ],
        ]);

        // Add "bloom_end" field
        $this->add([
            'type'  => 'select',
            'name' => 'bloom_end',
            'attributes' => [
                'id' => 'bloom_end'
            ],
            'options' => [
                'label' => 'End of blooming',
                'value_options' => [
                    1 => 'January',
                    2 => 'February',
                    3 => 'March',
                    4 => 'April',
                    5 => 'May',
                    6 => 'June',
                    7 => 'July',
                    8 => 'August',
                    9 => 'September',
                    10 => 'October',
                    11 => 'Novemeber',
                    12 => 'December'
                ]
            ],
        ]);
        
        // Add "tags" field
        $this->add([
            'type'  => 'text',
            'name' => 'tags',
            'attributes' => [                
                'id' => 'tags'
            ],
            'options' => [
                'label' => 'Tags',
            ],
        ]);
        
        // Add "status" field
        $this->add([
            'type'  => 'select',
            'name' => 'status',
            'attributes' => [                
                'id' => 'status'
            ],
            'options' => [
                'label' => 'Status',
                'value_options' => [
                    Post::STATUS_PUBLISHED => 'Published',
                    Post::STATUS_DRAFT => 'Draft',
                ]
            ],
        ]);
        
        // Add the submit button
        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [                
                'value' => 'Create',
                'id' => 'submitbutton',
            ],
        ]);
    }
    
    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter() 
    {
        
        $inputFilter = new InputFilter();        
        $this->setInputFilter($inputFilter);
        
        $inputFilter->add([
                'name'     => 'title',
                'required' => true,
                'filters'  => [
                    ['name' => 'StringTrim'],
                    ['name' => 'StripTags'],
                    ['name' => 'StripNewlines'],
                ],                
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 1,
                            'max' => 1024
                        ],
                    ],
                ],
            ]);
        
        $inputFilter->add([
                'name'     => 'description',
                'required' => true,
                'filters'  => [                    
                    ['name' => 'StripTags'],
                ],                
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 1,
                            'max' => 4096
                        ],
                    ],
                ],
            ]);

        $inputFilter->add([
            'name'     => 'short_description',
            'required' => false,
            'filters'  => [
                ['name' => 'StripTags'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 255
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'binomial_name',
            'required' => false,
            'filters'  => [
                ['name' => 'StripTags'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 100
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'family',
            'required' => false,
            'filters'  => [
                ['name' => 'StripTags'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 100
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'genus',
            'required' => false,
            'filters'  => [
                ['name' => 'StripTags'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 100
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'national_country',
            'required' => false,
            'filters'  => [
                ['name' => 'StripTags'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 100
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'city',
            'required' => false,
            'filters'  => [
                ['name' => 'StripTags'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 100
                    ],
                ],
            ],
        ]);

        // Add validation rules for the "image" field.
        $inputFilter->add([
            'type'     => 'Zend\InputFilter\FileInput',
            'name'     => 'image',
            'required' => false,
            'validators' => [
                ['name'    => 'FileUploadFile'],
                [
                    'name'    => 'FileMimeType',
                    'options' => [
                        'mimeType'  => ['image/jpeg', 'image/png']
                    ]
                ],
                ['name'    => 'FileIsImage'],
                [
                    'name'    => 'FileImageSize',
                    'options' => [
                        'minWidth'  => 128,
                        'minHeight' => 128,
                        'maxWidth'  => 4096,
                        'maxHeight' => 4096
                    ]
                ],
            ],
            'filters'  => [
                [
                    'name' => 'FileRenameUpload',
                    'options' => [
                        'target'=>'public/img/uploads',
                        'useUploadName'=>true,
                        'useUploadExtension'=>true,
                        'overwrite'=>true,
                        'randomize'=>false
                    ]
                ]
            ],
        ]);

        $inputFilter->add([
                'name'     => 'tags',
                'required' => true,
                'filters'  => [                    
                    ['name' => 'StringTrim'],
                    ['name' => 'StripTags'],
                    ['name' => 'StripNewlines'],
                ],                
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 1,
                            'max' => 1024
                        ],
                    ],
                ],
            ]);
    }
}

