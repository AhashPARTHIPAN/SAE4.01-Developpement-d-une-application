import mysql.connector
import openpyxl
import pandas as pd
import sys

# Pour se connecter à la BD
host = sys.argv[1]
user = sys.argv[2]
password = sys.argv[3]
database = sys.argv[4]

db = mysql.connector.connect(
    host=host,
    user=user,
    password=password,
    database=database,
    charset='utf8mb4'
)
cursor = db.cursor(dictionary=True)

# Requête SQL pour récup toutes les infos
query = """
    SELECT
        j.titre AS TITRE,
        GROUP_CONCAT(DISTINCT ed.nom SEPARATOR ', ') AS `REFERENCES (éditeur/distributeur)`,
        GROUP_CONCAT(DISTINCT a.nom SEPARATOR ', ') AS AUTEURS,
        j.date_parution_debut AS `DATE DE PARUTION DEBUT`,
        j.date_parution_fin AS `DATE DE PARUTION FIN`,
        j.information_date AS `INFORMATION DATE`,
        j.version AS VERSION,
        j.nombre_de_joueurs AS `NOMBRE DE JOUEURS`,
        j.age_indique AS `AGE INDIQUE (cf colonne B)`,
        j.mots_cles AS `MOTS CLES`,
        b.id_boite AS `N Boîte`,
        CONCAT(l.salle, ' - ', IFNULL(l.etagere, '')) AS LOCALISATION_CNJ,
        GROUP_CONCAT(DISTINCT m.nom ORDER BY m.nom ASC SEPARATOR '|||') AS MECANISMES,
        c.nom AS `Collection d'origine (cf colonne C)`,
        b.etat AS Etat,
        b.code_barre AS `Code barre`
    FROM jeu j
    LEFT JOIN boite b ON b.jeu_id = j.id_jeu
    LEFT JOIN localisation l ON l.localisation_id = b.localisation_id
    LEFT JOIN collection c ON c.collection_id = b.collection_id
    LEFT JOIN jeu_auteur ja ON ja.id_jeu = j.id_jeu
    LEFT JOIN auteur a ON a.auteur_id = ja.auteur_id
    LEFT JOIN jeu_editeur je ON je.id_jeu = j.id_jeu
    LEFT JOIN editeur ed ON ed.editeur_id = je.editeur_id
    LEFT JOIN jeu_mecanisme jm ON jm.id_jeu = j.id_jeu
    LEFT JOIN mecanisme m ON m.mecanisme_id = jm.id_mecanisme
    GROUP BY
        j.titre,
        j.date_parution_debut,
        j.date_parution_fin,
        j.information_date,
        j.version,
        j.nombre_de_joueurs,
        j.age_indique,
        j.mots_cles,
        b.id_boite,
        l.salle,
        l.etagere,
        c.nom,
        b.etat,
        b.code_barre
    ORDER BY j.titre;
"""

cursor.execute(query)
rows = cursor.fetchall()

# Préparation du fichier Excel
wb = openpyxl.Workbook()
ws = wb.active
ws.title = "Export jeux"

# Non des colonnes du tableau
headers = [
    "TITRE",
    "REFERENCES (éditeur/distributeur)",
    "AUTEURS",
    "DATE DE PARUTION DEBUT",
    "DATE DE PARUTION FIN",
    "INFORMATION DATE",
    "VERSION",
    "NOMBRE DE JOUEURS",
    "AGE INDIQUE (cf colonne B)",
    "MOTS CLES",
    "N Boîte",
    "LOCALISATION_CNJ",
    "MECANISME 1",
    "MECANISME 2",
    "MECANISME 3",
    "Collection d'origine (cf colonne C)",
    "Etat",
    "Code barre"
]
ws.append(headers)

# Lignes
for row in rows:
    mecanismes = row.get("MECANISMES", "")
    parts = mecanismes.split("|||") if mecanismes else []
    parts += [""] * (3 - len(parts))  # Complète jusqu'à 3 colonnes

    ligne = [
        row.get("TITRE", ""),
        row.get("REFERENCES (éditeur/distributeur)", ""),
        row.get("AUTEURS", ""),
        row.get("DATE DE PARUTION DEBUT", ""),
        row.get("DATE DE PARUTION FIN", ""),
        row.get("INFORMATION DATE", ""),
        row.get("VERSION", ""),
        row.get("NOMBRE DE JOUEURS", ""),
        row.get("AGE INDIQUE (cf colonne B)", ""),
        row.get("MOTS CLES", ""),
        row.get("N Boîte", ""),
        row.get("LOCALISATION_CNJ", ""),
        parts[0],
        parts[1],
        parts[2],
        row.get("Collection d'origine (cf colonne C)", ""),
        row.get("Etat", ""),
        row.get("Code barre", "")
    ]
    ws.append(ligne)

# Exécution de la requête
df = pd.read_sql(query, db)

# Chemin du fichier Excel (il faut le lancer depuis path/data/scripts_exportation)
output_path = "scripts/data/export_jeux.xlsx"

# Export vers Excel
df.to_excel(output_path, index=False)

print("Export terminé dans :", output_path)