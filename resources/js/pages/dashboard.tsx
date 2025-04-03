import FileUploader from '@/components/file-uplouder';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { FileItem } from '@/types/file-item';
import { Head, usePage } from '@inertiajs/react';
import { Trash2 } from 'lucide-react';
import { useEffect, useState } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Panel Główny',
        href: '/dashboard',
    },
];

export default function Dashboard() {
    const [files, setFiles] = useState<FileItem[]>([]);
    const { flash } = usePage().props as { flash?: { success?: string } };

    useEffect(() => {
        if (flash?.success) {
            setFiles([]);
        }
    }, [flash?.success]);

    const removeFile = (id: string) => {
        setFiles((prevFiles) => prevFiles.filter((file) => file.id !== id));
    };

    const handleUpload = async () => {
        const formData = new FormData();
        files.forEach(({ file }) => formData.append('files[]', file));

        try {
            const response = await fetch(route('pdf.generate'), {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                },
            });

            if (!response.ok) {
                throw new Error('Błąd podczas generowania PDF');
            }

            const blob = await response.blob();
            const filename = response.headers.get('Content-Disposition')?.split('filename=')[1]?.replace(/"/g, '') || 'plik.pdf';

            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = filename;
            link.click();
            URL.revokeObjectURL(link.href);

            setFiles([]);
        } catch (error) {
            console.error('Błąd przy uploadzie:', error);
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />

            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="relative min-h-[100vh] flex-1 overflow-hidden rounded-xl md:min-h-min">
                    <FileUploader onFilesSelected={(newFiles: FileItem[]) => setFiles((prev: FileItem[]) => [...prev, ...newFiles])} />

                    {files.length > 0 && (
                        <div className="mt-4 rounded-lg bg-gray-100 p-4 dark:bg-gray-100">
                            <h2 className="mb-2 text-sm font-semibold">Dodane pliki:</h2>
                            <ul className="space-y-2">
                                {files.map(({ id, file }) => (
                                    <li key={id} className="flex items-center justify-between rounded-md bg-white p-2 shadow-sm">
                                        <span className="text-sm text-gray-700 dark:text-gray-700">{file.name}</span>
                                        <Button variant="ghost" size="icon" onClick={() => removeFile(id)}>
                                            <Trash2 className="h-4 w-4 text-red-500" />
                                        </Button>
                                    </li>
                                ))}
                            </ul>
                        </div>
                    )}

                    <div className="mt-4 flex justify-end">
                        <Button
                            onClick={handleUpload}
                            disabled={files.length === 0}
                            className="rounded-lg bg-blue-600 px-6 py-3 text-white shadow-md hover:bg-blue-700 disabled:bg-gray-400"
                        >
                            Generuj
                        </Button>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
