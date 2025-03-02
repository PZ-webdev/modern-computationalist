import AppLayout from '@/layouts/app-layout';
import {type BreadcrumbItem} from '@/types';
import {Head, router, usePage} from '@inertiajs/react';
import FileUploader from "@/components/file-uplouder";
import React, {useEffect, useState} from 'react';
import {Button} from "@/components/ui/button";
import {Trash2} from "lucide-react";
import {FileItem} from '@/types/file-item';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Panel Główny',
        href: '/dashboard',
    },
];

export default function Dashboard() {
    const [files, setFiles] = useState<FileItem[]>([]);
    const {flash} = usePage().props as { flash?: { success?: string } };

    useEffect(() => {
        if (flash?.success) {
            setFiles([]);
        }
    }, [flash?.success]);

    const removeFile = (id: string) => {
        setFiles((prevFiles) => prevFiles.filter((file) => file.id !== id));
    };

    const handleUpload = () => {
        const formData = new FormData();

        files.forEach(({file}) => formData.append("files[]", file));

        // TODO: change endpoint
        router.post("/upload", formData, {
            onSuccess: () => {
                setFiles([]);
            },
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard"/>

            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div
                    className="relative min-h-[100vh] flex-1 overflow-hidden rounded-xl md:min-h-min">

                    <FileUploader
                        onFilesSelected={(newFiles: FileItem[]) => setFiles((prev: FileItem[]) => [...prev, ...newFiles])}
                    />

                    {files.length > 0 && (
                        <div className="bg-gray-100 p-4 rounded-lg mt-4 dark:bg-gray-100">
                            <h2 className="text-sm font-semibold mb-2">Dodane pliki:</h2>
                            <ul className="space-y-2">
                                {files.map(({id, file}) => (
                                    <li key={id}
                                        className="flex justify-between items-center bg-white p-2 rounded-md shadow-sm">
                                        <span className="text-gray-700 text-sm dark:text-gray-700">{file.name}</span>
                                        <Button variant="ghost" size="icon" onClick={() => removeFile(id)}>
                                            <Trash2 className="w-4 h-4 text-red-500"/>
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
                            className="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-md disabled:bg-gray-400"
                        >
                            Generuj
                        </Button>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
