import FOBasePage from '@pages/FO/FObasePage';

import type {Page} from 'playwright';

/**
 * Vouchers page, contains functions that can be used on the page
 * @class
 * @extends FOBasePage
 */
class Vouchers extends FOBasePage {
  public readonly pageTitle: string;

  private readonly vouchersTable: string;

  private readonly vouchersTableBody: string;

  private readonly vouchersTableRows: string;

  private readonly vouchersTableRow: (row: number) => string;

  private readonly tableColumnCode: (row: number) => string;

  private readonly tableColumnDescription: (row: number) => string;

  private readonly tableColumnQuantity: (row: number) => string;

  private readonly tableColumnValue: (row: number) => string;

  private readonly tableColumnMinimum: (row: number) => string;

  private readonly tableColumnCumulative: (row: number) => string;

  private readonly tableColumnExpirationDate: (row: number) => string;

  /**
   * @constructs
   * Setting up texts and selectors to use on vouchers page
   */
  constructor() {
    super();

    this.pageTitle = 'Discount';

    // Selectors
    this.vouchersTable = '#content table.table';
    this.vouchersTableBody = `${this.vouchersTable} tbody`;
    this.vouchersTableRows = `${this.vouchersTableBody} tr`;
    this.vouchersTableRow = (row: number) => `${this.vouchersTableRows}:nth-child(${row})`;
    this.tableColumnCode = (row: number) => `${this.vouchersTableRow(row)} th:nth-child(1)`;
    this.tableColumnDescription = (row: number) => `${this.vouchersTableRow(row)} td:nth-child(2)`;
    this.tableColumnQuantity = (row: number) => `${this.vouchersTableRow(row)} td:nth-child(3)`;
    this.tableColumnValue = (row: number) => `${this.vouchersTableRow(row)} td:nth-child(4)`;
    this.tableColumnMinimum = (row: number) => `${this.vouchersTableRow(row)} td:nth-child(5)`;
    this.tableColumnCumulative = (row: number) => `${this.vouchersTableRow(row)} td:nth-child(6)`;
    this.tableColumnExpirationDate = (row: number) => `${this.vouchersTableRow(row)} td:nth-child(7)`;
  }

  /*
  Methods
   */

  /**
   * Get text column from table vouchers
   * @param page {Page} Browser tab
   * @param row {number} Row number in vouchers table
   * @param columnName {string} Column name in vouchers table
   * @returns {Promise<string>}
   */
  async getTextColumnFromTableVouchers(page: Page, row: number, columnName: string): Promise<string> {
    let columnSelector:string;

    switch (columnName) {
      case 'code':
        columnSelector = this.tableColumnCode(row) as string;
        break;

      case 'description':
        columnSelector = this.tableColumnDescription(row) as string;
        break;

      case 'quantity':
        columnSelector = this.tableColumnQuantity(row) as string;
        break;

      case 'value':
        columnSelector = this.tableColumnValue(row) as string;
        break;

      case 'minimum':
        columnSelector = this.tableColumnMinimum(row) as string;
        break;

      case 'cumulative':
        columnSelector = this.tableColumnCumulative(row) as string;
        break;

      case 'expiration_date':
        columnSelector = this.tableColumnExpirationDate(row) as string;
        break;

      default:
        throw new Error(`Column ${columnName} was not found`);
    }

    return this.getTextContent(page, columnSelector);
  }
}

export default new Vouchers();
