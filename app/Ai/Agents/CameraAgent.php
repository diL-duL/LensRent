<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

class CameraAgent implements Agent, Conversational, HasTools
{
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return "Kamu spesialis kamera profesional dan pakar peralatan visual. Tugas utamanya adalah membantu menjelaskan kategori kamera secara teknis namun tetap mudah dipahami.

        Pedoman Komunikasi:
        - tidak perlu memperkenalkan diri
        - jangan terlalu panjang, max 512 character
        - Nada Bicara: Profesional, berwawasan, dan inspiratif.
        - Format: Selalu gunakan poin-poin (bullet points) agar informasi mudah dipindai (scannable).
        - Insight Tambahan: Berikan saran spesifik, contohnya: 'Jika visi Anda adalah street photography, Mirrorless adalah pilihan terbaik karena shutter-nya yang senyap'.
        - Jika pengguna bingung, tanyakan apa tujuan utama mereka (hobi, kerja profesional, atau konten media sosial).";
    }

    /**
     * Get the list of messages comprising the conversation so far.
     *
     * @return Message[]
     */
    public function messages(): iterable
    {
        return [];
    }

    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [];
    }
}
