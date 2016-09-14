<?php
namespace App\Forms;

use App\Model\Articles;
use Nette;
use App\Model\UserManager;
use Tracy\Debugger;


class ArticleFormFactory extends Nette\Object
{
    public $factory;
    
    public $articles;

    public function __construct(FormFactory $factory, Articles $articles)
    {
        $this->factory = $factory;
        $this->articles = $articles;
    }

    public function create()
    {
        $form = $this->factory->create();
        
        $form->addHidden('id');
        $form->addText('name', 'Name');
        $form->addTextArea('perex', 'Perex')->setAttribute('class', 'form-control');
        $form->addTextArea('text', 'Text');
        $form->addUpload('img', 'Image');
        $form->addCheckbox('logged_in_only', 'Only for logged in users');
        $form->addSubmit('submit', 'Save');

        $form->elementPrototype->addAttributes(array(
            'class' => 'col-lg-12 col-lg-offset-0',
        ));

        $form->onSubmit[] = $this->formSubmitted;

        return $form;
    }

    public function formSubmitted(Nette\Application\UI\Form $form)
    {
        Debugger::$strictMode = false;
        $values = $form->getValues();

        if(empty($values->text)){
            $form->addError('You have to fill out the field text');
        }
        if($form->hasErrors()){
            return;
        }
        
        $entry = [];

        if(empty($values->perex)){
            $values->perex = substr($values->text, 0, 500) . '...';
        }

        $entry['name'] = $values->name;
        $entry['perex'] = $values->perex;
        $entry['text'] = $values->text;
        $entry['logged_in_only'] = $values->logged_in_only;
        $entry['created_at'] = new Nette\Utils\DateTime();

        try{
            if(!empty($values->id)){
                $item = $this->articles->find($values->id);
                if(!empty($item)){
                    $item->update($entry);
                }
                else{
                    $item = $this->articles->insert($entry);
                    $form->setValues(array('id' => $item->id));
                }
            }
            else{
                $item = $this->articles->insert($entry);
                $form->setValues(array('id' => $item->id));
            }
        }
        catch(\Exception $e){
            Debugger::log($e->getMessage());
            $form->addError('The article was not saved due to a problem on the server');
            return;
        }

        if(!empty($values->img->name)){
            try{
                $image = Nette\Utils\Image::fromFile($values->img);
            }
            catch(\Exception $e){
                $form['img']->addError('Unsupported image format');
                return;
            }
            $img_name = $values->img->name;
            $extension = end(explode('.', $img_name));
            $new_name = "image-".date("U").substr((string)microtime(), 1, 6)."." . $extension;
            if(!is_dir(WWW_DIR . '/images/articles/' . $item->id . '/')){
                mkdir(WWW_DIR . '/images/articles/' . $item->id . '/');
            }
            $image->save(WWW_DIR . '/images/articles/' . $item->id . '/' . $new_name);
            $item->update(array('img' => $new_name));
        }

    }

}