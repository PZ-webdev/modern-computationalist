import {useCallback} from "react";
import {useDropzone} from "react-dropzone";
import {Button} from "@/components/ui/button";
import {FileItem} from '@/types/file-item';

export default function FileUploader({onFilesSelected}: { onFilesSelected: (files: FileItem[]) => void }) {
    const onDrop = useCallback((acceptedFiles: File[]) => {
        const filesWithId: FileItem[] = acceptedFiles.map((file) => ({
            id: crypto.randomUUID(),
            file,
        }));
        onFilesSelected(filesWithId);
    }, [onFilesSelected]);

    const {getRootProps, getInputProps} = useDropzone({
        onDrop,
        multiple: true,
        accept: {"text/plain": [".txt"]},
    });

    return (
        <div className="space-y-4">
            <div {...getRootProps()} className="border-2 border-dashed p-6 rounded-lg cursor-pointer text-center">
                <input {...getInputProps()} />
                <p className="text-gray-500">Przeciągnij i upuść pliki .txt lub kliknij, aby wybrać</p>
                <Button variant="outline" className="mt-4">Wybierz pliki</Button>
            </div>
        </div>
    );
}
