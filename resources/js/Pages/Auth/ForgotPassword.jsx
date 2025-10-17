import InputError from "@/Components/InputError";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import GuestLayout from "@/Layouts/GuestLayout";
import { Head, useForm } from "@inertiajs/react";
import "../../../scss/pages/Auth/forgot.scss";

export default function ForgotPassword({ status }) {
    const { data, setData, post, processing, errors } = useForm({
        email: "",
    });

    const submit = (e) => {
        e.preventDefault();

        post(route("password.email"));
    };

    return (
        <GuestLayout>
            <Head title="Forgot Password" />

            {/* Background */}
            <div className="forgot-background">
                <img
                    src="/images/BG-Forgot.jpg"
                    alt="Background"
                    className="bg-image"
                />
                <div className="overlay"></div>
            </div>

            {/* Container */}
            <div className="forgot-container">
                <div className="forgot-card">
                    <div className="forgot-header">
                        <h1>Forgot Password</h1>
                        <p>
                            Masukkan email terdaftar Anda, kami akan mengirimkan
                            link untuk reset password.
                        </p>
                    </div>

                    {/* Alert */}
                    {status && (
                        <div className="forgot-alert success">{status}</div>
                    )}

                    {/* Form */}
                    <form onSubmit={submit} className="forgot-form">
                        <div className="form-group">
                            <label htmlFor="email">Email</label>
                            <TextInput
                                id="email"
                                type="email"
                                name="email"
                                value={data.email}
                                className="form-input"
                                isFocused={true}
                                onChange={(e) =>
                                    setData("email", e.target.value)
                                }
                                required
                            />
                            <InputError
                                message={errors.email}
                                className="mt-2"
                            />
                        </div>

                        <button
                            type="submit"
                            className="btn-forgot"
                            disabled={processing}
                        >
                            Kirim Link Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </GuestLayout>
    );
}
