import HeadingSmall from '@/components/heading-small';
import AppLayout from '@/layouts/app-layout';
import SettingsLayout from '@/layouts/settings/layout';
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, usePage } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Profile settings',
        href: '/settings/profile',
    },
];

export default function Profile() {
    const { auth } = usePage<SharedData>().props;

    if (!auth.user) {
        return null;
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Profile settings" />

            <SettingsLayout>
                <div className="space-y-6">
                    <HeadingSmall
                        title="Portal profile"
                        description="Your Koamishin Portal account is the source of truth for your identity and credentials."
                    />

                    <dl className="grid gap-6 sm:grid-cols-2">
                        <div className="grid gap-2">
                            <dt className="text-sm font-medium">Name</dt>
                            <dd className="text-muted-foreground text-sm">{auth.user.name}</dd>
                        </div>
                        <div className="grid gap-2">
                            <dt className="text-sm font-medium">Email</dt>
                            <dd className="text-muted-foreground text-sm">{auth.user.email}</dd>
                        </div>
                        <div className="grid gap-2">
                            <dt className="text-sm font-medium">Email verification</dt>
                            <dd className="text-muted-foreground text-sm">{auth.user.emailVerified ? 'Verified' : 'Not verified'}</dd>
                        </div>
                    </dl>
                </div>
            </SettingsLayout>
        </AppLayout>
    );
}
