<?php

namespace AcMarche\Patrimoine\Entity;

use AcMarche\Patrimoine\Repository\ImageRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Table(name: 'patrioine_image')]
#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image implements TimestampableInterface
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;
    #[ORM\Column(type: 'string', length: 80)]
    private ?string $mime = null;
    #[Vich\UploadableField(mapping: 'patrimoine', fileNameProperty: 'fileName', size: 'fileSize')]
    private ?File $file = null;
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $fileName = null;
    #[ORM\Column(type: 'integer')]
    private ?int $fileSize = null;

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile $imageFile
     *
     * @throws Exception
     */
    public function setFile(?File $file = null): void
    {
        $this->file = $file;

        if (null !== $file) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function __construct(
        #[ORM\ManyToOne(targetEntity: Patrimoine::class, inversedBy: 'images')] private ?Patrimoine $patrimoine
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMime(): ?string
    {
        return $this->mime;
    }

    public function setMime(string $mime): self
    {
        $this->mime = $mime;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

    public function setFileSize(?int $fileSize): self
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    public function getPatrimoine(): ?Patrimoine
    {
        return $this->patrimoine;
    }

    public function setPatrimoine(?Patrimoine $patrimoine): self
    {
        $this->patrimoine = $patrimoine;

        return $this;
    }
}
