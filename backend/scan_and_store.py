import os
import sqlite3
from pathlib import Path
from datetime import datetime
import subprocess
import base64

# Chemins vers les dossiers et bases de données
public_data_path = Path("../public/public_data")
tree_db_path = Path("db/tree.db")  # Base de données pour l'arborescence
stats_db_path = Path("db/statistics.db")  # Base de données pour les statistiques

# Vérifier si FFMPEG est disponible
def is_ffmpeg_available():
    try:
        subprocess.run(["../bin/ffmpeg.exe", "-version"], stdout=subprocess.PIPE, stderr=subprocess.PIPE)
        return True
    except FileNotFoundError:
        return False

# Générer une preview pour une vidéo en base64
def generate_video_preview(video_path):
    try:
        # Créer une preview avec FFMPEG (1ère seconde de la vidéo)
        preview_path = "preview.jpg"
        subprocess.run([
            "../bin/ffmpeg.exe", "-i", video_path, "-ss", "00:00:01", "-vframes", "1", preview_path
        ], stdout=subprocess.PIPE, stderr=subprocess.PIPE)
        
        # Lire la preview en base64
        with open(preview_path, "rb") as f:
            preview_base64 = base64.b64encode(f.read()).decode("utf-8")
        
        # Supprimer le fichier temporaire
        os.remove(preview_path)
        return preview_base64
    except Exception as e:
        print(f"Erreur lors de la génération de la preview : {e}")
        return None

# Connexion à la base de données tree.db (arborescence)
tree_conn = sqlite3.connect(tree_db_path)
tree_cursor = tree_conn.cursor()

# Création de la table files dans tree.db si elle n'existe pas
tree_cursor.execute('''
CREATE TABLE IF NOT EXISTS files (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    parent_folder TEXT,
    folder_name TEXT,
    file_name TEXT,
    file_format TEXT,
    full_path TEXT UNIQUE,
    folder_path TEXT,
    classification TEXT,
    file_size INTEGER,
    creation_date TEXT,
    added_date TEXT,
    preview_base64 TEXT,
    likes INTEGER DEFAULT 0,
    dislikes INTEGER DEFAULT 0,
    views INTEGER DEFAULT 0
)
''')

# Connexion à la base de données statistics.db (statistiques)
stats_conn = sqlite3.connect(stats_db_path)
stats_cursor = stats_conn.cursor()

# Création de la table statistics dans statistics.db si elle n'existe pas
stats_cursor.execute('''
CREATE TABLE IF NOT EXISTS statistics (
    date TEXT PRIMARY KEY,
    total_files INTEGER,
    total_size INTEGER,
    most_common_format TEXT,
    most_common_classification TEXT,
    video_count INTEGER,
    image_count INTEGER,
    gif_count INTEGER
)
''')

# Fonction pour déterminer la classification d'un fichier
def get_classification(file_format):
    if file_format.lower() in ['jpg', 'png', 'webp']:
        return "image"
    elif file_format.lower() in ['mp4', 'webm']:
        return "vidéo"
    elif file_format.lower() == 'gif':
        return "gif"
    else:
        return "autre"

# Fonction pour vérifier si un fichier existe dans la base de données
def file_exists_in_db(full_path):
    tree_cursor.execute('SELECT id FROM files WHERE full_path = ?', (full_path,))
    return tree_cursor.fetchone() is not None

# Fonction pour supprimer les entrées de fichiers qui n'existent plus
def remove_missing_files(directory):
    # Récupérer tous les chemins de fichiers dans la base de données
    tree_cursor.execute('SELECT full_path FROM files')
    db_files = {row[0] for row in tree_cursor.fetchall()}
    
    # Récupérer tous les chemins de fichiers sur le disque
    disk_files = set()
    for root, _, files in os.walk(directory):
        for file in files:
            full_path = os.path.relpath(os.path.join(root, file), start=public_data_path)
            disk_files.add(full_path)
    
    # Supprimer les fichiers de la base de données qui n'existent plus sur le disque
    for db_file in db_files - disk_files:
        tree_cursor.execute('DELETE FROM files WHERE full_path = ?', (db_file,))
    tree_conn.commit()

# Fonction pour scanner le dossier et enregistrer les informations dans les bases de données
def scan_and_store(directory):
    file_stats = {
        'total_files': 0,
        'total_size': 0,
        'format_count': {},
        'classification_count': {},
        'video_count': 0,
        'image_count': 0,
        'gif_count': 0
    }
    
    for root, dirs, files in os.walk(directory):
        # Récupérer le nom du dossier parent
        parent_folder = os.path.basename(os.path.dirname(root))
        
        # Récupérer le nom du dossier courant
        folder_name = os.path.basename(root)
        
        # Si le dossier est "public", on écrit "null"
        if folder_name == "public":
            folder_name = "null"
        
        for file in files:
            # Récupérer le nom du fichier et son extension
            file_name, file_format = os.path.splitext(file)
            file_format = file_format[1:]  # Enlever le point de l'extension
            
            # Vérifier si le format du fichier est autorisé
            if file_format.lower() in ['jpg', 'png', 'webp', 'webm', 'mp4', 'gif']:
                # Récupérer le chemin complet du fichier
                full_path = os.path.relpath(os.path.join(root, file), start=public_data_path)
                
                # Vérifier si le fichier existe déjà dans la base de données
                if not file_exists_in_db(full_path):
                    # Récupérer les informations supplémentaires
                    file_stats['total_files'] += 1
                    file_size = os.path.getsize(os.path.join(root, file))
                    file_stats['total_size'] += file_size
                    file_stats['format_count'][file_format] = file_stats['format_count'].get(file_format, 0) + 1
                    
                    # Déterminer la classification du fichier
                    classification = get_classification(file_format)
                    file_stats['classification_count'][classification] = file_stats['classification_count'].get(classification, 0) + 1
                    
                    # Mettre à jour les compteurs par type
                    if classification == "vidéo":
                        file_stats['video_count'] += 1
                    elif classification == "image":
                        file_stats['image_count'] += 1
                    elif classification == "gif":
                        file_stats['gif_count'] += 1
                    
                    # Générer une preview pour les vidéos si FFMPEG est disponible
                    preview_base64 = None
                    if classification == "vidéo" and is_ffmpeg_available():
                        preview_base64 = generate_video_preview(os.path.join(root, file))
                    
                    # Récupérer la date de création du fichier
                    creation_date = datetime.fromtimestamp(os.path.getctime(os.path.join(root, file))).strftime("%Y/%m/%d")
                    
                    # Récupérer la date d'ajout dans la base de données
                    added_date = datetime.now().strftime("%Y/%m/%d")
                    
                    # Récupérer le chemin des dossiers sans le nom du fichier
                    folder_path = os.path.dirname(full_path)
                    
                    # Insérer les informations dans la base de données tree.db
                    tree_cursor.execute('''
                    INSERT INTO files (
                        parent_folder, folder_name, file_name, file_format, full_path, folder_path,
                        classification, file_size, creation_date, added_date, preview_base64
                    )
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                    ''', (
                        parent_folder, folder_name, file_name, file_format, full_path, folder_path,
                        classification, file_size, creation_date, added_date, preview_base64
                    ))
    
    # Enregistrer les statistiques quotidiennes dans statistics.db
    today = datetime.now().date().isoformat()
    most_common_format = max(file_stats['format_count'], key=file_stats['format_count'].get)
    most_common_classification = max(file_stats['classification_count'], key=file_stats['classification_count'].get)
    
    stats_cursor.execute('''
    INSERT OR IGNORE INTO statistics (
        date, total_files, total_size, most_common_format, most_common_classification,
        video_count, image_count, gif_count
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ''', (
        today, file_stats['total_files'], file_stats['total_size'], most_common_format,
        most_common_classification, file_stats['video_count'], file_stats['image_count'],
        file_stats['gif_count']
    ))
    
    # Valider les changements dans les bases de données
    tree_conn.commit()
    stats_conn.commit()

# Supprimer les fichiers manquants de la base de données
remove_missing_files(public_data_path)

# Scanner le dossier public_data et enregistrer les informations
scan_and_store(public_data_path)

# Fermer les connexions aux bases de données
tree_conn.close()
stats_conn.close()

print("Scan terminé et données enregistrées dans les bases de données.")