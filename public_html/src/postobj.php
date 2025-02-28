<?php

class PostObj
{
    private SQLite3 $db;
    public string $id;
    public string $header;
    public string $subheader;
    public string $previewimage;
    public string $content;
    public ?int $createdat;
    public ?int $updatedat;

    public function __construct(SQLite3 $db, string $id, string $header, string $subheader, string $previewimage, string $content, ?int $createdat = null, ?int $updatedat = null)
    {
        $this->db = $db;
        $this->id = $id;
        $this->header = $header;
        $this->subheader = $subheader;
        $this->previewimage = $previewimage;
        $this->content = $content;
        $this->createdat = $createdat;
        $this->updatedat = $updatedat;
    }

    public function save(): bool
    {
        $existingPost = self::load($this->db, $this->id);

        if ($existingPost)
        {
            return $this->update();
        }
        else
        {
            return $this->insert();
        }
    }

    private function insert(): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO articles (id, header, subheader, previewimage, content, createdat, updatedat)
            VALUES (:id, :header, :subheader, :previewimage, :content, :createdat, :updatedat);
        ");

        $stmt->bindValue(':id', $this->id, SQLITE3_TEXT);
        $stmt->bindValue(':header', $this->header, SQLITE3_TEXT);
        $stmt->bindValue(':subheader', $this->subheader, SQLITE3_TEXT);
        $stmt->bindValue(':previewimage', $this->previewimage, SQLITE3_TEXT);
        $stmt->bindValue(':content', $this->content, SQLITE3_TEXT);
        $stmt->bindValue(':createdat', time(), SQLITE3_INTEGER);
        $stmt->bindValue(':updatedat', time(), SQLITE3_INTEGER);

        if ($stmt->execute() !== false)
        {
            echo "post $this->id saved!<br>";
            return true;
        }
        else
        {
            echo "there was an issue saving post $this->id<br>";
            return false;
        }
    }

    private function update(): bool
    {
        $stmt = $this->db->prepare("
            UPDATE articles
            SET header = :header,
                subheader = :subheader,
                previewimage = :previewimage,
                content = :content,
                updatedat = :updatedat
            WHERE id = :id
            AND (header != :header OR subheader != :subheader OR previewimage != :previewimage OR content != :content);
        ");

        $stmt->bindValue(':id', $this->id, SQLITE3_TEXT);
        $stmt->bindValue(':header', $this->header, SQLITE3_TEXT);
        $stmt->bindValue(':subheader', $this->subheader, SQLITE3_TEXT);
        $stmt->bindValue(':previewimage', $this->previewimage, SQLITE3_TEXT);
        $stmt->bindValue(':content', $this->content, SQLITE3_TEXT);
        $stmt->bindValue(':updatedat', time(), SQLITE3_INTEGER); // Only update updatedat when content actually changes

        $stmt->execute();

        if ($this->db->changes() > 0)
        {
            echo "post $this->id updated!<br>";
            return true;
        }
        else
        {
            echo "there were no changes to be saved for post $this->id<br>";
            return false;
        }
    }

    public static function load(SQLite3 $db, string $id): ?self
    {
        $stmt = $db->prepare("SELECT * FROM articles WHERE id = :id");
        $stmt->bindValue(':id', $id, SQLITE3_TEXT);
        $post = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

        if (!$post) {
            return null; // Post not found
        }

        return new self(
            $db,
            $post['id'],
            $post['header'],
            $post['subheader'],
            $post['previewimage'],
            $post['content'],
            $post['createdat'],
            $post['updatedat']
        );
    }

    public function delete(): bool
    {
        $stmt = $this->db->prepare("DELETE FROM articles WHERE id = ?");
        $stmt->bindValue(':id', $this->id, SQLITE3_TEXT);
        $stmt->execute();
        return $this->db->changes() > 0;
    }

    public static function buildfromfile($db, $file, $dir): ?self
    {
            // rebuild the filepath with the system's proper separator
        $filePath = $dir . DIRECTORY_SEPARATOR . $file;

        // We only want to process files, the subdirectories are for unpublished articles.
        if (is_file($filePath))
        {
            // Id is just the filename without the extension
            $id = pathinfo($file, PATHINFO_FILENAME);

            // make sure we track this id so we know what files we have,
            // so we can remove DB entries that no longer have associated articles
            $currentFiles[] = $id;

            // get contents from the file
            $content = file_get_contents($filePath);

            // Extract header and subheader and any other lines that start with our # delimiter
            $header = '';
            $subheader = '';
            $contentLines = explode("\n", $content);
            $filteredContent = [];
            
            foreach ($contentLines as $line)
            {
                if (strpos($line, '#header:') === 0)
                {
                    $header = trim(substr($line, 8));
                }
                elseif (strpos($line, '#subheader:') === 0)
                {
                    $subheader = trim(substr($line, 11));
                }
                elseif (strpos($line, '#previewimage:') === 0)
                {
                    $previewimage = trim(substr($line, 14));
                }
                else
                {
                    $filteredContent[] = $line; // why don't more languages have this "append to first available index" thing?
                }
            }

            $filteredContent = implode("\n", $filteredContent);
            
            return new self(
                $db,
                $id,
                $header,
                $subheader,
                $previewimage,
                $filteredContent);
        }
        return null;
    }
}

?>