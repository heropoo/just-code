<?php

class FillModelPropertiesComment{

    /**
     * @var \PDO $pdo
     */
    protected $pdo;

    protected $tableName;

    public function __construct(\PDO $pdo, $tableName)
    {
        $this->pdo = $pdo;
        $this->tableName = $tableName;
    }

    public function fill($className){
        $ref = new \ReflectionClass($className);
        $commentString = $this->getPropertiesCommentString($ref->getName());
        $filename = $ref->getFileName();
        if (empty($ref->getDocComment())) {
            $this->insertAtLine($filename, $ref->getStartLine() - 2, $commentString."\n");
        }else{
            $content = file_get_contents($filename);
            $res = preg_match("#namespace ".str_replace('\\', '\\\\', $ref->getNamespaceName()).";\s+(/\*(\s|.)*?\*\/)\s+class {$ref->getShortName()}#", $content, $matches);
            if ($res) {
                $content = str_replace($matches[1], $commentString, $content);
                file_put_contents($filename, $content);
            }
        }
        return true;
    }

    protected function getPropertiesCommentString($className){
        $fields = $this->getTableFields();
        $commentString = "/**\n * Class $className \n";
        foreach ($fields as $field){
            $commentString .= " * @property {$field['type']} \${$field['field']} {$field['comment']}\n";
        }
        return $commentString . " */";
    }

    protected function getTableFields(){
        $list = $this->pdo->query('show full columns from '.$this->tableName)->fetchAll(\PDO::FETCH_ASSOC);
        $fields = [];
        foreach ($list as $item) {
            $field = $item['Field'];
            $sub_type_tmp = explode(' ', str_replace('(', ' ', $item['Type']));
            switch ($sub_type_tmp[0]) {
                case 'boolean':
                case 'bool':
                $type = 'boolean';
                    break;
                case 'varchar':
                case 'char':
                $type = 'string';
                    break;
                case 'int':
                case 'integer':
                case 'tinyint':
                case 'bigint':
                case 'smallint':
                case 'timestamp':
                $type = 'integer';
                    break;
                case 'real':
                case 'double':
                case 'float':
                $type = 'float';
                    break;
                case 'date':
                case 'datetime':
                $type = 'string';
                    break;
                default:
                    $type = 'mixed';
                    break;
            }
            $fields[] = [
                'type'=>$type,
                'field'=>$field,
                'comment'=>$item['Comment']
            ];
        }
        return $fields;
    }

    protected function insertAtLine($filename, $line, $content){
        $fileArr = file($filename);
        $lines = count($fileArr);
        if($line < 0){
            $line = 0;
        }else if($line > $lines){
            $line = $lines;
        }
        $fileArr[$line] .= $content;
        $newContent = implode('', $fileArr);
        return file_put_contents($filename,$newContent);
    }
}