<div class="playlists">
    <div class="playlists-header">
        <p><i class="ph ph-cards-three"></i> Playlist</p>
        <p>Files</p>
    </div>
    <div class="playlists-content">
        <ul>
            <li>
                <p>Name</p>
                <p>1</p>
            </li>
            <li>
                <p>X321321</p>
                <p>1</p>
            </li>
            <li>
                <p>dwadawdwa</p>
                <p>1</p>
            </li>
            <li>
                <p>X</p>
                <p>1</p>
            </li>
            <li>
                <p>Name</p>
                <p>1</p>
            </li>
            <li>
                <p>Name</p>
                <p>1</p>
            </li>
            <li>
                <p>Name</p>
                <p>1</p>
            </li>
            <li>
                <p>Name</p>
                <p>1</p>
            </li>
            <li>
                <p>Name</p>
                <p>1</p>
            </li>
            <li>
                <p>Name</p>
                <p>1</p>
            </li>
            <li>
                <p>Name</p>
                <p>1</p>
            </li>
            <li>
                <p>Name</p>
                <p>1</p>
            </li>
            <li>
                <p>Name</p>
                <p>1</p>
            </li>
            <li>
                <p>Name</p>
                <p>1</p>
            </li>
            <li>
                <p>Name</p>
                <p>1</p>
            </li>
            <li>
                <p>Name</p>
                <p>1</p>
            </li>
        </ul>
    </div>
</div>

<style>
    .album-modal {
        width: 50vw;
        height: 75vh;
        position: fixed;
        top: 15vh;
        left: 25vw;
        z-index: 30001;
        display: none;
        opacity: 0;
        justify-content: center;
        align-items: center;
        background: rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 7px;
    }

    .album-modal.show {
        display: flex;
        opacity: 1;
    }

    @media screen and (max-width: 768px) {
        .album-modal {
            width: 100vw;
            height: 100vh;
            top: 0;
            left: 0;
        }
    }

    .album-modal .ph.ph-x-square {
        position: absolute;
        top: 0;
        right: 0;
        margin: 1.5rem;
        padding: .25rem;
        color: var(--text-color);
        cursor: pointer;
        transition: var(--transition);
    }

    .album-modal .ph.ph-x-square:hover {
        color: red;
    }

    .playlists {
        width: 400px;
        height: 500px;
        background: var(--background-color);
        border-radius: 7px;
        overflow: hidden;
        box-shadow: -12px 12px 24px var(--background-color);
    }

    .playlists-header {
        padding-block: 1.5rem;
        box-shadow: 0 2px 0 var(--primary-color);
        padding-inline: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: var(--title-color);
    }

    .playlists-header p {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .playlists-content {
        display: flex;
        flex-direction: column;
    }

    .playlists-content ul li {
        display: flex;
        justify-content: space-between;
        padding-block: 1.5rem;
        padding-inline: 2rem;
        box-shadow: 0 1px 0 var(--dark-color);
        cursor: pointer;
        color: var(--text-color);
        transition: var(--transition);
    }

    .playlists-content ul li:hover {
        color: var(--primary-color);
        background: var(--dark-color);
    }
</style>