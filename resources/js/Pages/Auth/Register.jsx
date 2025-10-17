import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import GuestLayout from "@/Layouts/GuestLayout";
import { Head, Link, useForm } from "@inertiajs/react";
import "../../../scss/pages/Auth/register.scss";

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
    });

    const submit = (e) => {
        e.preventDefault();

        post(route("register"), {
            onFinish: () => reset("password", "password_confirmation"),
        });
    };

    return (
        <GuestLayout>
            <Head title="Register" />

            {/* Background */}
            <div className="register-background">
                <img
                    src="/images/BG-Register.jpg"
                    alt="background"
                    className="bg-image"
                />
                <div className="overlay"></div>
            </div>

            <div className="register-container">
                <div className="register-card">
                    <div className="register-header">
                        <span className="logo-icon">🌱</span>
                        <h1>Daftar ke SIPETA</h1>
                        <p>Bergabunglah dengan pasar digital petani lokal</p>
                    </div>

                    <form onSubmit={submit} className="register-form">
                        {/* Name */}
                        <div className="form-group">
                            <InputLabel htmlFor="name" value="Nama Lengkap" />
                            <TextInput
                                id="name"
                                name="name"
                                value={data.name}
                                className="form-input"
                                autoComplete="name"
                                isFocused={true}
                                onChange={(e) =>
                                    setData("name", e.target.value)
                                }
                                required
                            />
                            <InputError message={errors.name} />
                        </div>

                        {/* Email */}
                        <div className="form-group">
                            <InputLabel htmlFor="email" value="Email" />
                            <TextInput
                                id="email"
                                type="email"
                                name="email"
                                value={data.email}
                                className="form-input"
                                autoComplete="username"
                                onChange={(e) =>
                                    setData("email", e.target.value)
                                }
                                required
                            />
                            <InputError message={errors.email} />
                        </div>

                        {/* Password */}
                        <div className="form-group">
                            <InputLabel htmlFor="password" value="Password" />
                            <TextInput
                                id="password"
                                type="password"
                                name="password"
                                value={data.password}
                                className="form-input"
                                autoComplete="new-password"
                                onChange={(e) =>
                                    setData("password", e.target.value)
                                }
                                required
                            />
                            <InputError message={errors.password} />
                        </div>

                        {/* Confirm Password */}
                        <div className="form-group">
                            <InputLabel
                                htmlFor="password_confirmation"
                                value="Konfirmasi Password"
                            />
                            <TextInput
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                value={data.password_confirmation}
                                className="form-input"
                                autoComplete="new-password"
                                onChange={(e) =>
                                    setData(
                                        "password_confirmation",
                                        e.target.value
                                    )
                                }
                                required
                            />
                            <InputError
                                message={errors.password_confirmation}
                            />
                        </div>

                        {/* Actions */}
                        <div className="form-actions">
                            <Link href={route("login")} className="login-link">
                                Sudah punya akun?
                            </Link>
                            <PrimaryButton
                                className="btn-register"
                                disabled={processing}
                            >
                                Daftar
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </GuestLayout>
    );
}
