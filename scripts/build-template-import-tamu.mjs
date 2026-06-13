import fs from "node:fs/promises";
import { SpreadsheetFile, Workbook } from "@oai/artifact-tool";

const outputPath = "public/templates/template-import-tamu.xlsx";
const workbook = Workbook.create();
const dataSheet = workbook.worksheets.add("Data Tamu");

dataSheet.showGridLines = false;
dataSheet.getRange("A1:E1").values = [["Nama", "No. Telp", "Email", "Alamat", "Show Gift"]];
dataSheet.getRange("A1:E1").format = {
  fill: "#14513A",
  font: { bold: true, color: "#FFFFFF" },
  horizontalAlignment: "center",
  verticalAlignment: "center",
  borders: { preset: "all", style: "thin", color: "#0E3A29" },
};
dataSheet.getRange("A1:E1").format.rowHeight = 28;
dataSheet.getRange("A2:E101").format = {
  fill: "#FBF8F1",
  font: { color: "#2B2A24" },
  borders: { preset: "all", style: "thin", color: "#E4D9C5" },
  verticalAlignment: "center",
};
dataSheet.getRange("A2:E101").format.rowHeight = 22;
dataSheet.getRange("A1:A101").format.columnWidth = 27;
dataSheet.getRange("B1:B101").format.columnWidth = 20;
dataSheet.getRange("C1:C101").format.columnWidth = 30;
dataSheet.getRange("D1:D101").format.columnWidth = 42;
dataSheet.getRange("E1:E101").format.columnWidth = 15;
dataSheet.getRange("B2:B101").format.numberFormat = "@";
dataSheet.getRange("E2:E101").dataValidation = {
  rule: { type: "list", values: ["1", "0"] },
};
dataSheet.freezePanes.freezeRows(1);

const guide = workbook.worksheets.add("Petunjuk & Contoh");
guide.showGridLines = false;
guide.mergeCells("A1:E1");
guide.getRange("A1:E1").values = [["PETUNJUK IMPORT DATA TAMU"]];
guide.getRange("A1:E1").format = {
  fill: "#14513A",
  font: { bold: true, color: "#FFFFFF" },
  horizontalAlignment: "center",
  verticalAlignment: "center",
};
guide.getRange("A1:E1").format.rowHeight = 34;

guide.mergeCells("A3:E3");
guide.getRange("A3:E3").values = [[
  'Isi data pada sheet "Data Tamu". Jangan mengubah nama atau urutan kolom.',
]];
guide.getRange("A3:E3").format = {
  fill: "#F6F1E6",
  font: { bold: true, color: "#14513A" },
  wrapText: true,
};

guide.getRange("A5:E5").values = [["Kolom", "Wajib", "Format", "Contoh", "Keterangan"]];
guide.getRange("A5:E5").format = {
  fill: "#C2A14D",
  font: { bold: true, color: "#FFFFFF" },
  horizontalAlignment: "center",
  borders: { preset: "all", style: "thin", color: "#9A7D34" },
};
guide.getRange("A6:E10").values = [
  ["Nama", "Ya", "Teks", "Budi Santoso", "Nama tamu undangan"],
  ["No. Telp", "Tidak", "Teks", "0812-3456-7890", "Nomor WhatsApp; awalan 0 boleh"],
  ["Email", "Tidak", "Email", "budi@example.com", "Kosongkan jika tidak ada"],
  ["Alamat", "Tidak", "Teks", "Jakarta Selatan", "Kosongkan jika tidak ada"],
  ["Show Gift", "Tidak", "1 atau 0", "1", "1 = tampilkan amplop digital, 0 = sembunyikan"],
];
guide.getRange("A6:E10").format = {
  fill: "#FBF8F1",
  borders: { preset: "all", style: "thin", color: "#E4D9C5" },
  verticalAlignment: "top",
  wrapText: true,
};

guide.mergeCells("A12:E12");
guide.getRange("A12:E12").values = [["Contoh baris data (salin ke sheet Data Tamu bila diperlukan)"]];
guide.getRange("A12:E12").format = {
  fill: "#3A6E55",
  font: { bold: true, color: "#FFFFFF" },
};
guide.getRange("A13:E13").values = [["Nama", "No. Telp", "Email", "Alamat", "Show Gift"]];
guide.getRange("A13:E13").format = {
  fill: "#14513A",
  font: { bold: true, color: "#FFFFFF" },
  horizontalAlignment: "center",
  borders: { preset: "all", style: "thin", color: "#0E3A29" },
};
guide.getRange("A14:E16").values = [
  ["Budi Santoso", "0812-3456-7890", "budi@example.com", "Jakarta Selatan", "1"],
  ["Rina & Keluarga", "+62 812-3456-7890", "", "Bandung", "1"],
  ["Andi Pratama", "", "andi@example.com", "", "0"],
];
guide.getRange("A14:E16").format = {
  fill: "#FBF8F1",
  borders: { preset: "all", style: "thin", color: "#E4D9C5" },
};
guide.getRange("B14:B16").format.numberFormat = "@";
guide.getRange("A1:A16").format.columnWidth = 24;
guide.getRange("B1:B16").format.columnWidth = 16;
guide.getRange("C1:C16").format.columnWidth = 24;
guide.getRange("D1:D16").format.columnWidth = 28;
guide.getRange("E1:E16").format.columnWidth = 44;
guide.freezePanes.freezeRows(5);

await fs.mkdir("public/templates", { recursive: true });
const preview = await workbook.render({
  sheetName: "Petunjuk & Contoh",
  range: "A1:E16",
  scale: 1,
  format: "png",
});
await fs.writeFile("storage/app/template-import-tamu-preview.png", new Uint8Array(await preview.arrayBuffer()));
const dataPreview = await workbook.render({
  sheetName: "Data Tamu",
  range: "A1:E8",
  scale: 1,
  format: "png",
});
await fs.writeFile("storage/app/template-import-tamu-data-preview.png", new Uint8Array(await dataPreview.arrayBuffer()));

const output = await SpreadsheetFile.exportXlsx(workbook);
await output.save(outputPath);

const inspection = await workbook.inspect({
  kind: "table",
  range: "Data Tamu!A1:E6",
  include: "values,formulas",
  tableMaxRows: 6,
  tableMaxCols: 5,
});
console.log(inspection.ndjson);
console.log(outputPath);
